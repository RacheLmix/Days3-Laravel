<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PostRequest extends FormRequest
{
    /**
     * Xác định xem người dùng có được phép thực hiện yêu cầu này không.
     */
    public function authorize(): bool
    {
        return true; // Điều chỉnh dựa trên logic phân quyền của bạn
    }

    /**
     * Lấy các quy tắc xác thực áp dụng cho yêu cầu.
     */
    public function rules(): array
    {
        return [
            'title' => 'required|string|max:255',
            'content' => 'required',
            'author_id' => 'required|exists:authors,id',
            'status' => 'required|in:draft,published,archived',
            'published_at' => 'nullable|date',
        ];
    }

    /**
     * Lấy các thông báo lỗi tùy chỉnh cho các quy tắc xác thực.
     */
    public function messages(): array
    {
        return [
            'title.required' => 'Tiêu đề bài viết là bắt buộc.',
            'title.max' => 'Tiêu đề không được vượt quá 255 ký tự.',
            'content.required' => 'Nội dung bài viết là bắt buộc.',
            'author_id.required' => 'Tác giả là bắt buộc.',
            'author_id.exists' => 'Tác giả đã chọn không tồn tại.',
            'status.required' => 'Trạng thái bài viết là bắt buộc.',
            'status.in' => 'Trạng thái không hợp lệ.',
            'published_at.date' => 'Ngày xuất bản phải là định dạng ngày hợp lệ.',
        ];
    }

}