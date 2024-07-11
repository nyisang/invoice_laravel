<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
    <!-- Add your CSS links here -->
</head>
<body style="background-color: #3f8ceb ;">
    @extends('master')

    @section('content')
    <div class="container-fluid" style="height: 100vh; display: flex; justify-content: center; align-items: center;">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
                    <form method="post" action="{{ url('logininvoice') }}" style="background-color: #f2f2f2; padding: 0px; border-radius: 10px; width: 100%;">
                        <div class="card shadow" style="border-radius: 10px;">

                            <div class="card-header bg-success pt-2" style="border-top-left-radius: 10px; border-top-right-radius: 10px;">
                                <div class="card-title font-weight-bold text-white text-center"> Invoice System Login </div>
                            </div>

                            <div class="card-body">
                         

                                <div class="form-group">
                                    <label for="phonenumber"> Phone Number </label>
                                    <input type="text" name="phonenumber" id="phonenumber" class="form-control" placeholder="Enter Phone"/>
                            
                                </div>

                                <div class="form-group">
                                    <label for="password"> Password </label>
                                    <input type="password" name="password" id="password" class="form-control" placeholder="Enter Password" />

                                </div>
                            </div>

                            <div class="card-footer d-inline-block" style="border-bottom-left-radius: 10px; border-bottom-right-radius: 10px;">
                                <button type="submit" class="btn btn-success"> Login </button>
                              
                            </div>
                            <p class="float-right mt-2"> Don't have an account?  <a href="{{ url('signuppage')}}" class="text-success"> Register </a> </p>
                            @csrf
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @endsection
</body>
</html>
