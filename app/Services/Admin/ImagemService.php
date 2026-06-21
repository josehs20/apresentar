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
        if (!$request->hasFile($inputName)) {
            Log::info('[ImagemService] Nenhum arquivo enviado para o campo: ' . $inputName);
            return $model->caminho_imagem;
        }

        $file = $request->file($inputName);
        
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

            // Converte qualquer formato (webp, png, gif, etc.) para JPG
            $filename = time() . '_' . uniqid() . '.jpg';
            $relativePath = $pastaDestino . '/' . $filename;
            $fullPath = storage_path('app/public/' . $relativePath);
            $dir = dirname($fullPath);

            Log::info('[ImagemService] Preparando conversão para JPG', [
                'filename' => $filename,
                'relativePath' => $relativePath,
                'fullPath' => $fullPath,
                'sourcePath' => $file->getPathname(),
                'originalExtension' => $file->getClientOriginalExtension(),
            ]);

            if (!is_dir($dir)) {
                mkdir($dir, 0755, true);
                Log::info('[ImagemService] Diretório criado: ' . $dir);
            }

            // Lê o conteúdo do upload e converte para JPG com GD
            $imageContent = @file_get_contents($file->getPathname());
            if ($imageContent === false) {
                Log::error('[ImagemService] Não foi possível ler o arquivo temporário');
                throw new \RuntimeException('Erro ao ler arquivo temporário');
            }

            $sourceImage = @imagecreatefromstring($imageContent);
            if ($sourceImage !== false) {
                // Cria fundo branco (essencial para PNG/GIF com transparência)
                $jpgImage = imagecreatetruecolor(imagesx($sourceImage), imagesy($sourceImage));
                $white = imagecolorallocate($jpgImage, 255, 255, 255);
                imagefilledrectangle($jpgImage, 0, 0, imagesx($sourceImage), imagesy($sourceImage), $white);
                imagecopy($jpgImage, $sourceImage, 0, 0, 0, 0, imagesx($sourceImage), imagesy($sourceImage));

                // Salva como JPEG com qualidade 90
                $saved = imagejpeg($jpgImage, $fullPath, 90);
                imagedestroy($sourceImage);
                imagedestroy($jpgImage);

                if (!$saved) {
                    Log::error('[ImagemService] Falha ao salvar imagem como JPEG');
                    throw new \RuntimeException('Erro ao salvar JPEG');
                }

                Log::info('[ImagemService] Imagem convertida para JPG com sucesso');
            } else {
                // Fallback: se não for imagem reconhecível, copia como está
                Log::warning('[ImagemService] Arquivo não é uma imagem válida, copiando como está');
                $copied = copy($file->getPathname(), $fullPath);
                if (!$copied) {
                    Log::error('[ImagemService] Falha ao copiar arquivo não-imagem');
                    throw new \RuntimeException('Erro ao copiar arquivo não-imagem');
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
                throw new \RuntimeException('Arquivo não existe após salvamento');
            }

            // Atualiza o model
            $model->caminho_imagem = $relativePath;
            $model->meta_imagem = $relativePath;
            $model->save();

            return $relativePath;
        } catch (\Exception $e) {
            Log::error('[ImagemService] Exceção ao salvar imagem', [
                'message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => $e->getTraceAsString(),
            ]);
            throw $e; // Relança para que a transação em ProdutoService seja revertida
        }
    }
}