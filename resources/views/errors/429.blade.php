@extends('errors::minimal')

@section('title', __('Too Many Requests'))
@section('code', '429')
@section('message', __('ย้อนกลับ ไม่พบหน้าที่คุณต้องการ'))
