<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet">
    
</head>

<style>
    @import url('https://fonts.googleapis.com/css?family=Montserrat:400,700&display=swap');

    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
        font-family: 'Montserrat', sans-serif;
    }

    body {
        display: flex;
        justify-content: center;
        align-items: center;
        min-height: 100vh;
        background-color: #0C4160;
        padding: 30px 10px;
    }

    .card {
        max-width: 500px;
        margin: auto;
        color: black;
        border-radius: 20px;
    }

    p {
        margin: 0px;
    }

    .container .h8 {
        font-size: 30px;
        font-weight: 800;
        text-align: center;
    }

    .btn.btn-primary {
        width: 30%;
        margin-bottom: 30px;
        display: flex;
        align-items: center;
        justify-content: center;
        
        background-image: linear-gradient(to right, #0dc55a 0%, #19b9b6 51%, #0ccf0c 100%);
        border: none;
        transition: 0.5s;
        background-size: 200% auto;
    }
    .btn.btn-danger {
        width: 30%;
        margin-bottom: 30px;
        margin-left: 20px;
        display: flex;
        align-items: center;
        justify-content: center;
       
        background-image: linear-gradient(to right, #2077c8 0%, #8d0707d6 51%, #810909 100%);
        border: none;
        transition: 0.5s;
        background-size: 200% auto;
    }

    .btn.btn-primary:hover {
        background-position: right center;
        color: #fff;
        text-decoration: none;
    }

    .btn.btn-primary:hover .fas.fa-arrow-right {
        transform: translate(15px);
        transition: transform 0.2s ease-in;
    }

    .form-control {
        color: white;
        background-color: #223C60;
        border: 2px solid transparent;
        height: 60px;
        padding-left: 20px;
        vertical-align: middle;
    }

    .form-control:focus {
        color: white;
        background-color: #0C4160;
        border: 2px solid #2d4dda;
        box-shadow: none;
    }

    .text {
        font-size: 14px;
        font-weight: 600;
    }

    ::placeholder {
        font-size: 14px;
        font-weight: 600;
    }

    .btn-primary.save {
        background-color: green;
        margin-right: auto;
    }

    .btn-primary.cancel {
        background-color: red;
        margin-left: auto;
    }
</style>
<body>
      
    <div class="container p-0">
        <div class="card px-4">
            <p class="h8 py-3">Payment Details</p>
			<?php 	$cardnumber     = $this->encrypt->decode($row[0]->cardnumber);
					$cardcvv        = $this->encrypt->decode($row[0]->cardcvv);?>
			<form class="card-details " action="<?php echo base_url();?>api/test/pay_transaction" method="post">
			<input type="hidden" name="id" value="<?php echo $row[0]->id;?>">
			<input type="hidden" name="token" value="<?php echo $row[0]->token;?>">
			<input type="hidden" name="callbackurl" value="<?php echo $row[0]->callbackurl;?>">
			<input type="hidden" name="merchant_transaction_id" value="<?php echo $row[0]->merchant_transaction_id;?>">
            <div class="row gx-3">
                <div class="col-12">
                    <div class="d-flex flex-column">
                        <p class="text mb-1">Person Name</p>
                        <input class="form-control mb-3" type="text"  name="cardholdername" placeholder="Name" value="<?php echo $row[0]->cardholdername;?>" required>
                    </div>
                </div>
                <div class="col-12">
                    <div class="d-flex flex-column">
                        <p class="text mb-1">Card Number</p>
                        <input type="number" class="form-control mb-3" name="cardnumber" type="text" placeholder="1234 5678 435678" value="<?php echo $cardnumber;?>" required>
                    </div>
                </div>
                <div class="col-6">
                    <div class="d-flex flex-column">
                        <p class="text mb-1">Expiry</p>
                        <input id="expiryInput" class="form-control mb-3" name="expiry" type="text" placeholder="MM/YYYY" value="<?php echo $row[0]->expirymonth.'/'.$row[0]->expiryyear;?>" required>
                    </div>
                </div>
                
                <div class="col-6">
                    <div class="d-flex flex-column">
                        <p class="text mb-1">CVV/CVC</p>
                        <input type="password" class="form-control mb-3 pt-2" type="text" name="cardcvv" maxlength="3" pattern="\d{3}" placeholder="***" title="Please enter a 3-digit CVV/CVC code" value="<?php echo $cardcvv;?>" required>
                    </div>
                </div>
                
                <div class="col-12 d-flex justify-content-between">
                    <button type="submit" class="btn btn-primary save" name="transaction_status" value="Success">Success</button>
                    <button type="submit" class="btn btn-danger cancel" name="transaction_status" value="Failed">Failed</button>
                </div>
            </div>
			</form>
        </div>
    </div>
</body>


<script>
    document.addEventListener('DOMContentLoaded', function() {
        const expiryInput = document.getElementById('expiryInput');

        expiryInput.addEventListener('input', function() {
            const trimmedValue = expiryInput.value.replace(/\D/g, '').substring(0, 6);
            const formattedValue = trimmedValue.replace(/(\d{2})(\d{4})/, '$1/$2');
            expiryInput.value = formattedValue;
        });
    });
</script>
</html>
