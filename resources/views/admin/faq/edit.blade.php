@extends('admin.layouts.app')
@section('web_page_title', 'Edit Faq') 
@section('content')
                <div class="page-content">
                    <div class="container-fluid"> 
                        <!-- start page title -->
                        <div class="row">
                            <div class="col-12">
                                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                                    <h4 class="mb-sm-0 font-size-18">Edit Faq</h4>

                                    <div class="page-title-right">
                                        <ol class="breadcrumb m-0">
                                            <li class="breadcrumb-item"><a href="{{ route('faq.index') }}">Faqs</a></li>
                                            <li class="breadcrumb-item active">Edit Faq</li>
                                        </ol>
                                    </div>

                                </div>
                            </div>
                        </div>
                        <!-- end page title -->

                        <form id="createproject-form" autocomplete="off"    class="repeater"   novalidate  action="{{ route('faq.update', $faq->id) }}" method="POST">
                        @csrf
                        @method("PUT")
                            <div class="row">
                                <div class="col-lg-8">
                                @include('admin.layouts.message')
                                    <div class="card">
                                        <div class="card-body">   
                                            <div class="mb-3">
                                                <label for="projectname-input" class="form-label">Question</label> 
                                                <input id="question" name="question" type="text" class="form-control" placeholder="Enter question..." required value="{{ old('question', $faq->question) }}"> 
                                            </div> 
                                            <div class="mb-3">
                                                <label for="description" class="form-label">Answer</label>
                                                <textarea class="form-control editor" name="answer" rows="6">{{ old('answer', $faq->answer) }}</textarea>  
                                            </div>   
                                            <div class="mb-3">
                                                <label for="projectname-input" class="form-label">Order </label> 
                                                <input id="order" name="order" type="number" class="form-control" placeholder="Enter order ..." required value="{{ old('order', $faq->order) }}" > 
                                            </div>   
                                            <div class="mb-3">
                                                <label class="form-label">Status</label> 
                                                <select class="form-control"  name="status"> 
                                                    <option value="1"  @if(old('status', $faq->status)  ==  1 ) selected @endif >Active</option> 
                                                    <option value="0"  @if(old('status', $faq->status)  ==  0 ) selected @endif >InActive</option>
                                                </select> 
                                            </div>   
                                        </div>
                                        <!-- end card body -->
                                         
                                    </div>
                                    <!-- end card -->
                                    
                                </div>
                                <!-- end col --> 

                                <div class="col-lg-8">
                                    <div class="text-end mb-4">
                                        <button type="submit" class="btn btn-primary">Update Faq</button>
                                    </div>
                                </div>
                            </div>
                            <!-- end row -->
                        </form>

                    </div> <!-- container-fluid -->
                </div>
                <!-- End Page-content -->

@endsection
 