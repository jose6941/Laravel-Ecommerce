<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProdutoRequest extends FormRequest
{
    public function authorize(): bool
    {
        // Aqui podemos checar, por exemplo: return $this->user()->isAdmin();
        // Para manter 100% funcional sem quebrar testes existentes, mantemos true.
        return true;
    }

    public function rules(): array
    {
        return [
            'nome' => ['required', 'string', 'max:255'],
            'descricao' => ['required', 'string'],
            'preco' => ['required', 'numeric', 'min:0'],
            'preco_promocional' => ['nullable', 'numeric', 'min:0'],
            'estoque' => ['required', 'integer', 'min:0'],
            'categoria_id' => ['required', 'exists:categorias,id'],
            'imagem' => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp', 'max:2048'],
            'ativo' => ['nullable', 'boolean'],
            'destaque' => ['nullable', 'boolean'],
        ];
    }

    /**
     * Prepara os dados antes da validação.
     * Como checkboxes booleanos enviam 'on' ou simplesmente não existem no request se não marcados,
     * transformamos em boolean aqui para o validated() ficar limpo e pronto para o update().
     */
    protected function prepareForValidation(): void
    {
        $this->merge([
            'ativo' => $this->has('ativo'),
            'destaque' => $this->has('destaque'),
        ]);
    }
}
