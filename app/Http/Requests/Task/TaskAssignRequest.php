<?php

namespace App\Http\Requests\Task;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;
use Illuminate\Validation\Rule;

class TaskAssignRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
//            'task' => [
//                'required',
//                Rule::exists('tasks', 'id')->where(function ($query) {
//                    $query->where('project_id', $this->route('project')); // Validate task exists within the specified project
//                }),
//            ],
//            'project' => [
//                'required',
//                Rule::exists('projects', 'id'),
//            ],
        ];
    }


    public function all($keys = null)
    {
        $data = parent::all($keys);
        $task = $this->route('task');
        $project = $this->route('task');

        $data['task'] = $task?->id;
        $data['project'] = $project?->id;
        return $data;
    }

    public function messages()
    {
        return [
            'task.required' => 'Task ID is required.',
            'task.exists' => 'The selected task does not exist.',
            'project.required' => 'Project ID is required.',
            'project.exists' => 'The selected project does not exist.',
        ];
    }

    /**
     *  Filters to be applied to the input.
     *
     * @return array
     */
    public function filters()
    {
        return [
            // 'email' => 'trim|lowercase',
            'title' => 'trim|capitalize|escape',
            'description' => 'trim|capitalize|escape'
        ];
    }

    /**
     * Handle a failed validation attempt.
     *
     * @param \Illuminate\Contracts\Validation\Validator $validator
     * @return void
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    protected function failedValidation(Validator $validator)
    {
        $errors = (new ValidationException($validator))->errors();
        throw new HttpResponseException(response()->json(['errors' => $errors
        ], JsonResponse::HTTP_UNPROCESSABLE_ENTITY));
    }
}
