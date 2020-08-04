@extends('errors::minimal')

@section('title', Translator::phrase('Server_Error'))
@section('code', '500')
@section('message', Translator::phrase('Server_Error'))
