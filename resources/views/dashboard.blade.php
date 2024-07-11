<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Side Bar and Menu Bar</title>
    <link rel="stylesheet" href="../../style/style.css"></head>
    <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css'>
    <!-- Boxicons CDN Link -->
    <link href='https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css' rel='stylesheet'>
     <meta name="viewport" content="width=device-width, initial-scale=1.0">
     <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<body>
@include('Allsidebar');

    <div class="content">
        <div class="menu-bar">
            <ul>
                <li><a href="#">Welcome, {{$invoiceusers->{'first_name'} }} {{$invoiceusers->{'last_name'} }}</a></li>
               
            </ul>
        </div>
        <div class="main-content">
        <div class="card-title font-weight-bold text-white text-center"> All Transactions</div>
        <table>
            <thead>
                <tr>
                <th style="text-align: center; width: 50px;"></th>
                    <th >Phone number</th>
                    <th>Amount</th>
                 
                </tr>
            </thead>
            <tbody> 
                            @foreach ($alltransactions as $alltransaction)
                            <tr>
                       
                                <td class="text-info"   style="font-size: 13px; color: black;font-weight: bold;">{{($alltransaction->BillRefNumber )}}</td>
                                <td class="text-info"   style="font-size: 13px; color: black;font-weight: bold;">{{($alltransaction->TransAmount)}}</td>

                            </tr>
                        @endforeach
                              </tbody>
        </table>
        </div>
    </div>

    <div id="MyNumber" class="modal fade" role="dialog">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Pay Using My Number</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <div class="modal-body">

          <form method="post" action="{{url('store_invoicepayments')}}" enctype="multipart/form-data">
            {{ csrf_field() }}
  
                  <div class="form-group">
                    <label for="amount"><b>Amount</b></label>
                    <input type="amount" class="form-control"  name="amount" required  />
                  </div>
               

            <button type="submit" class="btn btn-primary">submit</button>
          </form>
        </div>
      </div>
    </div>
  </div>

  <div id="OtherNumber" class="modal fade" role="dialog">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Pay Using Other Number</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <div class="modal-body">

          <form method="post" action="{{url('store_invoicepayments')}}" enctype="multipart/form-data">
            {{ csrf_field() }}
            <div class="form-group">
                    <label for="phonenumber"><b>Phone number</b></label>
                    <input type="phonenumber" class="form-control"  name="phonenumber" required  />
                  </div>
                  <div class="form-group">
                    <label for="amount"><b>Amount</b></label>
                    <input type="amount" class="form-control"  name="amount" required  />
                  </div>
               

            <button type="submit" class="btn btn-primary">submit</button>
          </form>
        </div>
      </div>
    </div>
  </div>
</body>
</html>
