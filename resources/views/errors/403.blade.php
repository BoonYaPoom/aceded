@extends('errors::minimal')

@section('title', __('Forbidden'))
@section('code', '403')
@section('message', __($exception->getMessage() ?: 'ย้อนกลับ ไม่พบหน้าที่คุณต้องการ'))
