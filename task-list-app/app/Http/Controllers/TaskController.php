<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    { 
        $tasks = Task::orderBy('created_at','DESC')->paginate(5);  // Lấy tất cả các task từ cơ sở dữ liệu
        return view('tasks.index', compact('tasks'));  // Trả về view danh sách các task
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('tasks.create');  // Trả về view để tạo task mới
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Xác thực dữ liệu đầu vào
        $request->validate([
            'title' => 'required',  // Tiêu đề là bắt buộc
            'description' => 'required',  // Mô tả là bắt buộc
        ]);

        // Xử lý checkbox 'completed', chuyển thành 1 (true) hoặc 0 (false)
        $data = $request->all();
        $data['completed'] = $request->has('completed') ? 1 : 0;  // Nếu checkbox có, gán 1, nếu không có, gán 0

        // Lưu task mới vào cơ sở dữ liệu
        Task::create($data);

        // Chuyển hướng về trang danh sách và thông báo thành công
        return redirect()->route('tasks.index')->with('success', 'Task created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Task $task)
    {
        return view('tasks.show', compact('task'));  // Trả về view để hiển thị chi tiết task
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Task $task)
    {
        return view('tasks.edit', compact('task'));  // Trả về view để chỉnh sửa task
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Task $task)
    {
        // Xác thực dữ liệu đầu vào
        $request->validate([
            'title' => 'required',  // Tiêu đề là bắt buộc
            'description' => 'required',  // Mô tả là bắt buộc
        ]);

        // Xử lý checkbox 'completed', chuyển thành 1 (true) hoặc 0 (false)
        $data = $request->all();
        $data['completed'] = $request->has('completed') ? 1 : 0;  // Nếu checkbox có, gán 1, nếu không có, gán 0

        // Cập nhật task trong cơ sở dữ liệu
        $task->update($data);

        // Chuyển hướng về trang danh sách và thông báo thành công
        return redirect()->route('tasks.index')->with('success', 'Task updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Task $task)
    {
        // Xóa task khỏi cơ sở dữ liệu
        $task->delete();

        // Chuyển hướng về trang danh sách và thông báo thành công
        return redirect()->route('tasks.index')->with('success', 'Task deleted successfully.');
    }
}
