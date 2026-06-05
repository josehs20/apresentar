<?php

namespace App\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class ProcessarImagem implements ShouldQueue
{
    use Queueable;

    public string $caminho;
    public ?string $modelType;
    public ?int $modelId;

    /**
     * Create a new job instance.
     */
    public function __construct(string $caminho, ?string $modelType = null, ?int $modelId = null)
    {
        $this->caminho = $caminho;
        $this->modelType = $modelType;
        $this->modelId = $modelId;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        try {
            $tempDisk = Storage::disk('local');
            $publicDisk = Storage::disk('public');

            if (!$tempDisk->exists($this->caminho)) {
                Log::warning('Imagem temporária não encontrada: ' . $this->caminho);
                return;
            }

            // Caminho final no disco public
            $relativePath = 'produtos/' . basename($this->caminho);
            $extension = pathinfo($this->caminho, PATHINFO_EXTENSION);

            // Se já for WebP, pode manter, caso contrário converter
            if (strtolower($extension) !== 'webp') {
                $relativePath = 'produtos/' . pathinfo($this->caminho, PATHINFO_FILENAME) . '.webp';
            }

            // Processar com Intervention
            $manager = new ImageManager(new Driver());
            $image = $manager->read($tempDisk->get($this->caminho));

            // Redimensionar para máximo 1200px
            $image->scaleDown(width: 1200);

            // Codificar como WebP com qualidade 80%
            $encoded = $image->toWebp(quality: 80);

            // Salvar no disco public
            $publicDisk->put($relativePath, $encoded);

            // Atualizar o registro no banco se informado
            if ($this->modelType && $this->modelId) {
                $model = $this->modelType::find($this->modelId);
                if ($model) {
                    $model->caminho_imagem = $relativePath;
                    $model->save();
                }
            }

            // Remover arquivo temporário
            $tempDisk->delete($this->caminho);

            Log::info('Imagem processada com sucesso: ' . $relativePath);
        } catch (\Exception $e) {
            Log::error('Erro ao processar imagem: ' . $e->getMessage());
            throw $e;
        }
    }
}