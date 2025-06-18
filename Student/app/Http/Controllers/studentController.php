<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Student;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class studentController extends Controller
{
/**
 * @OA\Get(
 *     path="/api/students",
 *     summary="Listar todos los estudiantes",
 *     tags={"Students"},
 *     @OA\Response(
 *         response=200,
 *         description="Lista de estudiantes",
 *         @OA\JsonContent(
 *             @OA\Property(property="students", type="array", @OA\Items(ref="#/components/schemas/Student")),
 *             @OA\Property(property="status", type="integer", example=200)
 *         )
 *     )
 * )
 */


    public function index()
    {
        $students = Student::all();
        //if ($students->isEmpty()) {
        //    $data = [
        //        'message' => 'No se encontraron el servidor estudiantes',
        //        'status' => 200
        //    ];
        //    return response()->json([$data], 404);
        //}
        $data = [
            'students' => $students,
            'status' => 200
        ];

        return response()->json($data, 200);
    }
/**
 * @OA\Post(
 *     path="/api/students",
 *     summary="Crear un nuevo estudiante",
 *     tags={"Students"},
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(ref="#/components/schemas/Student")
 *     ),
 *     @OA\Response(response=201, description="Estudiante creado correctamente"),
 *     @OA\Response(response=400, description="Error de validación")
 * )
 */


    public function store(Request $request)
    {
        $validator = validator::make($request->all(), [
            'name' => 'required|max:255',
            'email' => 'required|email|unique:student',
            'phone' => 'required|digits:10',
            'language' => 'required|in:Spanish,English'
        ]);

        if ($validator->fails()) {
            $data = [
                'message' => 'No se encontraron el servidor estudiantes',
                'errors' => $validator->errors(),
                'status' => 400
            ];
            return response()->json([$data], 400);
        }
        $student = Student::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'language' => $request->language
        ]);
        if (!$student) {
            $data = [
                'message' => "Error al crear estudiante",
                'status' => 500
            ];
            return response()->json([$data], 500);
        }
        $data = [
            'student' => $student,
            'status' => 201
        ];
        return response()->json([$data], 201);
    }
    /**
 * @OA\Get(
 *     path="/api/students/{id}",
 *     summary="Obtener un estudiante por ID",
 *     tags={"Students"},
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         @OA\Schema(type="integer")
 *     ),
 *     @OA\Response(response=200, description="Estudiante encontrado"),
 *     @OA\Response(response=404, description="Estudiante no encontrado")
 * )
 */

    public function show($id){

        $student=Student::find($id);
        if(!$student){
            $data=[
                'message'=>'Estudiante nom encontrado',
                'status'=>404
            ];
            return response()->json($data,404);
        }
        $data=[
            'student'=>$student,
            'status'=>200
        ];
        return response()->json($data,200);
    }
    /**
 * @OA\Delete(
 *     path="/api/students/{id}",
 *     summary="Eliminar un estudiante",
 *     tags={"Students"},
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         @OA\Schema(type="integer")
 *     ),
 *     @OA\Response(response=200, description="Estudiante eliminado"),
 *     @OA\Response(response=404, description="Estudiante no encontrado")
 * )
 */

    public function destroy($id){
        $student=Student::find($id);
        if(!$student){
            $data=[
                'message'=>'Estudiante no encontrado',
                'status'=>404
            ];
            return response()->json($data,404);
        }
        $student->delete();

        $data=[
            'student'=>$student,
            'status'=>200
        ];
        return response()->json($data,200);
    }
    /**
 * @OA\Put(
 *     path="/api/students/{id}",
 *     summary="Actualizar completamente un estudiante",
 *     tags={"Students"},
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         @OA\Schema(type="integer")
 *     ),
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(
 *             required={"name","email","phone","language"},
 *             @OA\Property(property="name", type="string"),
 *             @OA\Property(property="email", type="string"),
 *             @OA\Property(property="phone", type="string"),
 *             @OA\Property(property="language", type="string")
 *         )
 *     ),
 *     @OA\Response(response=200, description="Estudiante actualizado"),
 *     @OA\Response(response=400, description="Error de validación"),
 *     @OA\Response(response=404, description="Estudiante no encontrado")
 * )
 */


    public function update(Request $request, $id){
        $student=Student::find($id);
        if(!$student){
            $data=[
                'message'=>'Estudiante no encontrado',
                'status'=>404
            ];
            return response()->json($data,404);
        }
        $validator = validator::make($request->all(), [
            'name' => 'required|max:255',
            'email' => 'required|email|unique:student',
            'phone' => 'required|digits:10',
            'language' => 'required|in:Spanish,English'
        ]);
        if ($validator->fails()) {
            $data = [
                'message' => 'No se encontraron el servidor estudiantes',
                'errors' => $validator->errors(),
                'status' => 400
            ];
            return response()->json([$data], 400);
        }
        $student->name=$request->name;
        $student->email=$request->email;
        $student->phone=$request->phone;
        $student->language=$request->language;

        $student->save();

        $data=[
            'message'=>'Estudiante Actualizado',
            'student'=>$student,
            'status'=>200
        ];
        return response()->json($data,200);
    }
    /**
 * @OA\Patch(
 *     path="/api/students/{id}",
 *     summary="Actualizar parcialmente un estudiante",
 *     tags={"Students"},
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         @OA\Schema(type="integer")
 *     ),
 *     @OA\RequestBody(
 *         required=false,
 *         @OA\JsonContent(
 *             @OA\Property(property="name", type="string"),
 *             @OA\Property(property="email", type="string"),
 *             @OA\Property(property="phone", type="string"),
 *             @OA\Property(property="language", type="string")
 *         )
 *     ),
 *     @OA\Response(response=200, description="Estudiante actualizado parcialmente"),
 *     @OA\Response(response=400, description="Error de validación"),
 *     @OA\Response(response=404, description="Estudiante no encontrado")
 * )
 */

    public function updatePartial(Request $request, $id){
        $student=Student::find($id);
        if(!$student){
            $data=[
                'message'=>'Estudiante no encontrado',
                'status'=>404
            ];
            return response()->json($data,404);
        }
        $validator = validator::make($request->all(), [
            'name' => 'max:255',
            'email' => 'email|unique:student',
            'phone' => 'digits:10',
            'language' => 'in:Spanish,English'
        ]);
        if ($validator->fails()) {
            $data = [
                'message' => 'No se encontraron el servidor estudiantes',
                'errors' => $validator->errors(),
                'status' => 400
            ];
            return response()->json([$data], 400);
        }
        if($request->has('name')){
            $student->name=$request->name;
        }
        if($request->has('email')){
            $student->email=$request->email;
        }
        if($request->has('phone')){
            $student->phone=$request->phone;
        }
        if($request->has('language')){
            $student->language=$request->language;
        }

        $student->save();

        $data=[
            'message'=>'Estudiante Actualizado',
            'student'=>$student,
            'status'=>200
        ];
        return response()->json($data,200);
    }
}