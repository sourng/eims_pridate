@extends('errors::minimal')

@section('title', Translator::phrase('Forbidden'))
@section('code', '403')
@section('message', Translator::phrase(($exception->getMessage() ?: 'Forbidden'))
