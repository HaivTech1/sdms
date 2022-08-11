<x-app-layout>
    @section('title', application('name') . ' | Student Page')

    @push('styles')
    .parent {
        display: flex;
        justify-content: space-between;
    }
    @endpush
    <x-slot name="header">
        <h4 class="mb-sm-0 font-size-18">Student</h4>

        <div class="page-title-right">
            <ol class="breadcrumb m-0">
                <li class="breadcrumb-item active">Show | {{ $student->firstName()}}</li>
            </ol>
        </div>
    </x-slot>

    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <div class="invoice-title">
                        <h4 class="float-end font-size-16">Order # 12345</h4>
                        <div class="mb-4">
                            <img src="assets/images/logo-dark.png" alt="logo" height="20"/>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-sm-6">
                            <address>
                                <strong>Billed To:</strong><br>
                                John Smith<br>
                                1234 Main<br>
                                Apt. 4B<br>
                                Springfield, ST 54321
                            </address>
                        </div>
                        <div class="col-sm-6 text-sm-end">
                            <address class="mt-2 mt-sm-0">
                                <strong>Shipped To:</strong><br>
                                Kenny Rigdon<br>
                                1234 Main<br>
                                Apt. 4B<br>
                                Springfield, ST 54321
                            </address>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6 mt-3">
                            <address>
                                <strong>Payment Method:</strong><br>
                                Visa ending **** 4242<br>
                                jsmith@email.com
                            </address>
                        </div>
                        <div class="col-sm-6 mt-3 text-sm-end">
                            <address>
                                <strong>Order Date:</strong><br>
                                October 16, 2019<br><br>
                            </address>
                        </div>
                    </div>
                    <div class="py-2 mt-3">
                        <h3 class="font-size-15 fw-bold">Order summary</h3>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-nowrap">
                            <thead>
                                <tr>
                                    <th style="width: 70px;">No.</th>
                                    <th>Item</th>
                                    <th class="text-end">Price</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>01</td>
                                    <td>Skote - Admin Dashboard Template</td>
                                    <td class="text-end">$499.00</td>
                                </tr>
                                
                                <tr>
                                    <td>02</td>
                                    <td>Skote - Landing Template</td>
                                    <td class="text-end">$399.00</td>
                                </tr>

                                <tr>
                                    <td>03</td>
                                    <td>Veltrix - Admin Dashboard Template</td>
                                    <td class="text-end">$499.00</td>
                                </tr>
                                <tr>
                                    <td colspan="2" class="text-end">Sub Total</td>
                                    <td class="text-end">$1397.00</td>
                                </tr>
                                <tr>
                                    <td colspan="2" class="border-0 text-end">
                                        <strong>Shipping</strong></td>
                                    <td class="border-0 text-end">$13.00</td>
                                </tr>
                                <tr>
                                    <td colspan="2" class="border-0 text-end">
                                        <strong>Total</strong></td>
                                    <td class="border-0 text-end"><h4 class="m-0">$1410.00</h4></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="d-print-none">
                        <div class="float-end">
                            <a href="javascript:window.print()" class="btn btn-success waves-effect waves-light me-1"><i class="fa fa-print"></i></a>
                            <a href="javascript: void(0);" class="btn btn-primary w-md waves-effect waves-light">Send</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class='panel panel-primary'>
            <div class='panel-body'>
                <div class='parent'>
                    <div class='col-xs-2 col-sm-2 col-md-2 text-center'>
                        <img class='img-rounded img-responsive' src='' alt='logo'/>
                    </div>
        
                    <div class='col-xs-8 col-sm-8 col-md-8 text-center'>
                        <h3> God's Grace Schol</h3>
                        <p class='text-danger'>
                        knFsknfslka<br/>
                        </p>
                    </div>
        
                    <div class='col-xs-2 col-sm-2 col-md-2 text-center text-responsive'> 
                        <img src='' class='img-rounded img-responsive' alt='logo' />
                    </div>
                </div>
                <hr />
        
                <div class='parent'>
                    <div class='col-xs-4 col-md-4'>
                        <legend>Basic Information</legend>
                        <p>Surname: Adeboye <p>
                        <p>First Name: </p>
                        <p>Other Name: </p>
                        <p>Gender: </p>
                        <p>State of Origin: </p>
                        <p>Nationality:</p>
                        <p>Father Name: </p>
                        <p>Mother Name: </p>
                    </div>
                    <div class='col-xs-4 col-md-4'>
                        <legend>Birthday</legend>
                        <p>Age: </p>
                        <p>Date: </p>
                        <p>Month: </p>
                        <p>Year: </p>
                    </div>
                    <div class='col-xs-4 col-md-4'>
                        <legend>Contact</legend>
                        <p>Student Phone</p>
                        <p>Nearest Contact1: sFNKSkmnsd,gn.zdk</p>
                        <p>Nearest Contact2: asfhzajfnsjklfgnsk</p>
                        <p>Nearest Contact3: cASFJsfjkzbsk</p>
                        <p>Health Conditions: aJFAJKLSFHsklfASk</p>
                        <p>Home Address: afhsjfhlsjfask</p>
                        <p>Father's Phone: sfnsjkLFNASKLfnaso</p>
                        <p>Mother's Phone: aFJBSLJKFSBNKf</p>
                        <p>Father Occupation: snkfsklnfslk</p>
                        <p>Mother Occupation: kfzsnsklnls</p>
                    </div>
                </div>
                <br />
        
                <div class='parent'>
                    <div class='col-xs-4 col-md-4'>
                        <legend>Academics</legend>
                        <p>Registration No: knfksnfsk</p>
                        <p>Password: knafkasnfkjnfa</p>
                        <p>Class: ljfksnflnks</p>
                    </div>
                    <div class='col-xs-4 col-md-4'>
                        <legend>Sponsor:</legend>
                        <p>Name: kafnklfnlknl</p>
                        <p>Phone: knsafkzanfkns</p>
                        <p>Relationship: ,nkf zsjnflkns</p>
                    </div>
                    <div class='col-xs-4 col-md-4'>
                        <legend>Registered</legend>
                        <p>Date: sfnhsjfhslkjfs</p>
                        <p>Month:slfnzs kfnksdngks</p>
                        <p>Year: sfgnskzjnsjkgnzdj,</p>
                    </div>
                </div>
            </div>
            <br/>
            <hr/>
    
            <div class='row'>
                <div class='col-xs-12 col-md-12 text-center'>
                    <em>
                        <strong>NOTE:</strong> Print this slip and keep it safe, you will require this for effective service of your school portal. 
                        We are always ready to asisst in any way we can. 
                        <br/>
                        <span class='fa fa-phone'></span> 2348165541693,&nbsp;&nbsp;
                        <span class='fa fa-envelope'></span> chibuezevictor6@gmail.com &nbsp;&nbsp;
                    </em>
                </div>
            </div>
        </div>
    </div>

    
</x-app-layout>
