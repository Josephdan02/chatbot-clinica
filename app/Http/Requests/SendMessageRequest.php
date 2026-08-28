<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\ValidationException;

class SendMessageRequest extends FormRequest
{
    protected function prepareForValidation(): void
{

    if (! $this->filled('user_identifier') && $this->filled('userIdentifier')) {
        $this->merge([
            'user_identifier' => $this->input('userIdentifier')
        ]);
    }
}

    public function authorize(): bool
    {
        return true;
    }

    protected function failedValidation(Validator $validator): void
    {
        throw new ValidationException($validator, response()->json([
            'success' => false,
            'message' => 'La solicitud contiene datos inválidos.',
            'data' => [],
            'errors' => $validator->errors(),
        ], 422));
    }

    public function rules(): array
    {
        return [
            // Si no se envía conversation_id, el controller crea una conversación nueva
            // (útil para probar sin tener que llamar primero a /api/chat/start).
            'conversation_id' => ['nullable', 'integer', 'exists:conversations,id'],

            // Requerido siempre: permite crear conversación nueva y validar pertenencia
            // cuando se envía conversation_id.
            'user_identifier' => ['required', 'string', 'max:255'],
            'userIdentifier' => ['sometimes', 'string', 'max:255'],

            'message' => ['required', 'string', 'max:2000'],
        ];
    }
}
