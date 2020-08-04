@extends('errors::minimal')

@section('title', Translator::phrase('Too_Many_Requests'))
@section('code', '429')
@section('message', Translator::phrase('Too_Many_Requests'))
