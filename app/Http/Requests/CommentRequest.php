<?php

namespace App\Http\Requests;

use App\Models\User;
use App\Models\Lesson;
use App\Models\Assignment;
use App\Contracts\CommentAble;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Http\FormRequest;

class CommentRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Auth::check() ? true : false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'body'              => ['required', 'max:250'],
            'parent_id'         => ['nullable'],
            'depth'             => ['nullable'],
            'commentable_id'    => ['required'],
            // 'commentable_type'  => ['required', 'in:' . Lesson::TABLE],
        ];
    }

    public function author(): User
    {
        return $this->user();
    }

    public function body(): string
    {
        return $this->get('body');
    }

    public function parentId(): ?int
    {
        return $this->get('parent_id');
    }

    public function depth(): ?int
    {
        return $this->get('depth');
    }

    public function commentAble(): CommentAble
    {
        return $this->findCommentAble($this->get('commentable_id'), $this->get('commentable_type'));
    }

    public function findCommentAble(int $id, string $type): CommentAble
    {
        switch ($type) {
            case Lesson::TABLE:
                return Lesson::find($id);
            case Assignment::TABLE:
                    return Assignment::find($id);
        }
        abort(404, $type.' NOT FOUND');
    }
}
