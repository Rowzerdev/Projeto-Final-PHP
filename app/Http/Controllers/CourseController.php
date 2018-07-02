<?php

namespace App\Http\Controllers;

use auth;
use App\User;
use App\Course;
use App\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Session\Session;

class CourseController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $user = Auth::User();
        $course = Course::paginate(1);

        if($user->admin){
            
            return view('admin/courses/index', ['course' => $course]);
        }else{
            return view('students/index',['course'=>$course]);
        } 
    }

    public function create() 
    {
        return view('admin/courses/new');
    }

    public function store(Request $request) 
    {
        $p = new Course;
        $p->curso = $request->input('curso');
        $p->ementa = $request->input('ementa');
        $p->max_aluno = $request->input('max_aluno');

        
        if ($p->save()) {
            \Session::flash('status', 'Curso criado com sucesso.');
            return redirect('/Course');
        } else {
            \Session::flash('status', 'Ocorreu um erro ao criar o curso.');
            return view('Course.new');
        }
    }

    public function edit($id) {
        $course = Course::findOrFail($id);

        return view('Courses.edit', ['Course' => $course]);
    }

    public function delete($id) {
        $course = Course::findOrFail($id);

        return view('Course.delete', ['Course' => $state]); 
    }

    public function update(Request $request, $id) {
        $p = Course::findOrFail($id);
        $p->curso = $request->input('curso');
        $p->ementa = $request->input('ementa');
        $p->max_aluno = $request->input('max_aluno');

        
        if ($p->save()) {
            \Session::flash('status', 'Curso atualizado com sucesso.');
            return redirect('/Course');
        } else {
            \Session::flash('status', 'Ocorreu um erro ao atualizar o curso.');
            return view('Course.edit', ['Course' => $p]);
        }
    }

    public function destroy($id) {
        $p = Course::findOrFail($id);
        $p->delete();

        \Session::flash('status', 'Curso excluído com sucesso.');
        return redirect('/Course');
    }
}