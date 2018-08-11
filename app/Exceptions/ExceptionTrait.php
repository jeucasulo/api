<?php 

namespace App\Exceptions;

use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Symfony\Component\HttpFoundation\Response;

trait ExceptionTrait{
	public function apiException($request, $e){

		// if($e instanceof ModelNotFoundException){
		if($this->isModel($e)){
		    return response()->json([
		        'errors' => "Product Model not found"
		    ],Response::HTTP_NOT_FOUND);
		}
		
		if($this->isHttp($e)){
		    return response()->json([
		        'errors' => "Incorect route"
		    ],Response::HTTP_NOT_FOUND);
		}

		return $request->all();
	}

	public function isModel($e){
		return $e instanceof ModelNotFoundException;
	}

	public function isHttp($e){
		return $e instanceof NotFoundHttpException;
	}



}