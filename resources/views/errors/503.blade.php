@extends('errors::minimal')

@section('title', Translator::phrase('Service_Unavailable'))
@section('code', '503')
@section('message', Translator::phrase($exception->getMessage() ?: 'Service_Unavailable'))
