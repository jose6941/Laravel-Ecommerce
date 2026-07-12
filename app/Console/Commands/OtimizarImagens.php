<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class OtimizarImagens extends Command
{
    protected $signature = 'images:optimize
        {--max-width=1200 : Largura máxima em pixels}
        {--quality=80 : Qualidade JPEG (1-100)}
        {--dry-run : Apenas mostra o que seria feito, sem modificar}';

    protected $description = 'Otimiza todas as imagens JPG dos produtos, redimensionando e comprimindo';

    public function handle(): int
    {
        $maxWidth = (int) $this->option('max-width');
        $quality = (int) $this->option('quality');
        $dryRun = (bool) $this->option('dry-run');

        $disk = Storage::disk('public');
        $files = $disk->files('images/products');

        $imagens = array_values(array_filter($files, fn ($f) => Str::endsWith(Str::lower($f), '.jpg')));

        if (empty($imagens)) {
            $this->warn('Nenhuma imagem JPG encontrada em storage/app/public/images/products/');
            return Command::SUCCESS;
        }

        $this->line("🔍 Encontradas <fg=white>{$this->formatNumber(count($imagens))}</> imagens JPG");
        $this->line("📐 Redimensionando para max-width: <fg=white>{$maxWidth}px</>");
        $this->line("🎯 Qualidade JPEG: <fg=white>{$quality}%</>");
        $this->newLine();

        $totalOriginal = 0;
        $totalOtimo = 0;
        $processadas = 0;
        $puladas = 0;
        $erros = 0;

        $bar = $this->output->createProgressBar(count($imagens));
        $bar->setFormat("\n<fg=yellow>⏳ Processando...</>\n %current%/%max% [%bar%] %percent:3s%%\n ⏱  %estimated:-6s%  %memory:6s%\n");
        $bar->start();

        foreach ($imagens as $imagem) {
            $fullPath = $disk->path($imagem);
            $originalSize = filesize($fullPath);
            $totalOriginal += $originalSize;

            if ($dryRun) {
                $bar->advance();
                continue;
            }

            try {
                $info = getimagesize($fullPath);
                if ($info === false) {
                    $this->warn("\n⚠ Imagem inválida: {$imagem}");
                    $puladas++;
                    $bar->advance();
                    continue;
                }

                [$origW, $origH, $type] = $info;

                if ($type !== IMAGETYPE_JPEG) {
                    $puladas++;
                    $bar->advance();
                    continue;
                }

                // Só redimensiona se for maior que o limite
                if ($origW <= $maxWidth && $origH <= $maxWidth) {
                    // Mesmo assim, comprimimos para reduzir tamanho
                    $img = @imagecreatefromjpeg($fullPath);
                    if ($img === false) {
                        $erros++;
                        $bar->advance();
                        continue;
                    }
                    imagejpeg($img, $fullPath, $quality);
                    imagedestroy($img);
                } else {
                    // Calcula novas dimensões mantendo proporção
                    $ratio = min($maxWidth / $origW, $maxWidth / $origH);
                    $newW = (int) round($origW * $ratio);
                    $newH = (int) round($origH * $ratio);

                    $src = @imagecreatefromjpeg($fullPath);
                    if ($src === false) {
                        $erros++;
                        $bar->advance();
                        continue;
                    }

                    $dst = imagecreatetruecolor($newW, $newH);
                    imagecopyresampled($dst, $src, 0, 0, 0, 0, $newW, $newH, $origW, $origH);
                    imagejpeg($dst, $fullPath, $quality);

                    imagedestroy($src);
                    imagedestroy($dst);
                }

                $novoSize = filesize($fullPath);
                $totalOtimo += $novoSize;
                $processadas++;
            } catch (\Throwable $e) {
                $erros++;
                if ($this->option('verbose')) {
                    $this->warn("\n❌ Erro em {$imagem}: {$e->getMessage()}");
                }
            }

            $bar->advance();
        }

        $bar->finish();
        $this->newLine(2);

        // Resultados
        $this->components->twoColumnDetail('<fg=green>✓ Imagens processadas</>', (string) $processadas);

        if ($puladas > 0) {
            $this->components->twoColumnDetail('<fg=yellow>⚠ Imagens não JPEG puladas</>', (string) $puladas);
        }
        if ($erros > 0) {
            $this->components->twoColumnDetail('<fg=red>✗ Erros</>', (string) $erros);
        }

        $this->newLine();

        if ($dryRun) {
            $this->components->info('Modo --dry-run ativo. Nenhuma imagem foi modificada.');
            return Command::SUCCESS;
        }

        $economiaBytes = $totalOriginal - $totalOtimo;
        $economiaPct = $totalOriginal > 0
            ? round(($economiaBytes / $totalOriginal) * 100, 1)
            : 0;

        $this->table(
            ['Métrica', 'Valor'],
            [
                ['📦 Tamanho original', $this->formatBytes($totalOriginal)],
                ['📦 Tamanho após otimização', $this->formatBytes($totalOtimo)],
                ['💾 Economia', $this->formatBytes($economiaBytes) . " ({$economiaPct}%)"],
            ]
        );

        if ($economiaPct > 50) {
            $this->components->success("Imagens otimizadas com sucesso! Economia de {$economiaPct}%!");
        } elseif ($economiaPct > 0) {
            $this->components->info("Imagens otimizadas. Economia de {$economiaPct}%.");
        } else {
            $this->components->warn('Nenhuma economia significativa. As imagens já devem estar compactadas.');
        }

        return Command::SUCCESS;
    }

    private function formatBytes(int $bytes, int $precision = 2): string
    {
        $units = ['B', 'KB', 'MB', 'GB'];
        $i = 0;
        while ($bytes >= 1024 && $i < count($units) - 1) {
            $bytes /= 1024;
            $i++;
        }
        return number_format($bytes, $precision, ',', '.') . ' ' . $units[$i];
    }

    private function formatNumber(int $n): string
    {
        return number_format($n, 0, ',', '.');
    }
}
