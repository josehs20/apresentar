<?php

namespace App\Services\Admin;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class ImagemService
{
    /**
     * Salva a imagem do upload diretamente no storage público.
     * Retorna o caminho relativo no disco public.
     */
    public static function processarUpload($request, string $inputName, $model, string $pastaDestino = 'produtos'): ?string
    {
        Log::info('[ImagemService] Iniciando processarUpload', [
            'hasFile' => $request->hasFile($inputName),
            'inputName' => $inputName,
            'model' => get_class($model),
            'model_id' => $model->id,
            'pasta' => $pastaDestino,
        ]);
   
        if (!$request->hasFile($inputName)) {
            Log::info('[ImagemService] Nenhum arquivo enviado para o campo: ' . $inputName);
            return $model->caminho_imagem;
        }

        $file = $request->file($inputName);
        
        Log::info('[ImagemService] Arquivo recebido', [
            'originalName' => $file->getClientOriginalName(),
            'mime' => $file->getMimeType(),
            'size' => $file->getSize(),
            'error' => $file->getError(),
            'isValid' => $file->isValid(),
            'pathname' => $file->getPathname(),
        ]);

        try {
            $disk = Storage::disk('public');
            
            // Apaga imagem anterior do storage
            if ($model->caminho_imagem) {
                $exists = $disk->exists($model->caminho_imagem);
                Log::info('[ImagemService] Imagem anterior', [
                    'path' => $model->caminho_imagem,
                    'exists' => $exists,
                ]);
                if ($exists) {
                    $deleted = $disk->delete($model->caminho_imagem);
                    Log::info('[ImagemService] Imagem anterior deletada: ' . ($deleted ? 'sim' : 'falha'));
                }
            }

            // Usa cópia direta do arquivo temporário (mais confiável)
            $extension = $file->getClientOriginalExtension() ?: 'jpg';
            $filename = time() . '_' . uniqid() . '.' . $extension;
            $relativePath = $pastaDestino . '/' . $filename;
            $fullPath = storage_path('app/public/' . $relativePath);
            $dir = dirname($fullPath);

            Log::info('[ImagemService] Preparando cópia direta', [
                'filename' => $filename,
                'relativePath' => $relativePath,
                'fullPath' => $fullPath,
                'sourcePath' => $file->getPathname(),
            ]);

            if (!is_dir($dir)) {
                mkdir($dir, 0755, true);
                Log::info('[ImagemService] Diretório criado: ' . $dir);
            }

            // Tenta mover primeiro (mais eficiente), senão copia
            $moved = @rename($file->getPathname(), $fullPath);
            if (!$moved) {
                $copied = copy($file->getPathname(), $fullPath);
                Log::info('[ImagemService] rename falhou, tentando copy', ['copied' => $copied]);
                if (!$copied) {
                    Log::error('[ImagemService] Falha total: nem rename nem copy funcionaram');
                    return null;
                }
            }

            // Define permissões corretas (0644 = rw-r--r--)
            @chmod($fullPath, 0644);

            $exists = file_exists($fullPath);
            Log::info('[ImagemService] Arquivo salvo', [
                'relativePath' => $relativePath,
                'fullPath' => $fullPath,
                'exists' => $exists,
                'size' => $exists ? filesize($fullPath) : 0,
                'perms' => $exists ? substr(sprintf('%o', fileperms($fullPath)), -4) : 'N/A',
            ]);

            if (!$exists) {
                Log::error('[ImagemService] Arquivo não existe após salvamento');
                return null;
            }

            // Atualiza o model
            $model->caminho_imagem = $relativePath;
            $model->meta_imagem = $relativePath;
            $model->save();

            Log::info('[ImagemService] Model atualizado com sucesso', [
                'caminho_imagem' => $model->caminho_imagem,
                'model_id' => $model->id,
            ]);

            return $relativePath;
        } catch (\Exception $e) {
            Log::error('[ImagemService] Exceção ao salvar imagem', [
                'message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => $e->getTraceAsString(),
            ]);
            return null;
        }
    }
}