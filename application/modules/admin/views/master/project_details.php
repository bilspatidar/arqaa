<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Project Details</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        .container {
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 10px;
            font-size: 16px; /* Adjust font size for normal view */
        }
        .detail-container {
            margin-bottom: 20px;
        }
        .detail-row {
            margin-bottom: 10px;
            display: flex;
        }
        .detail-label {
            flex: 1;
            font-weight: bold;
        }
        .detail-value {
            flex: 2;
        }
        .print-btn {
            display: block;
            width: 100%;
            padding: 10px;
            margin-top: 20px;
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
        }
        .print-btn:hover {
            background-color: #0056b3;
        }

        /* Additional CSS for printing */
        @media print {
            body * {
                visibility: hidden;
            }
            .container, .container * {
                visibility: visible;
            }
            .container {
                position: absolute;
                left: 0;
                top: 0;
                width: 100%;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="detail-container">
            <!-- PHP code for displaying project details -->
            <?php 
                $amount = $row[0]->amount;
                $get_total_income = $this->Internal_model->getTotalIncome($row[0]->id);
                $due_amount = $amount - $get_total_income;
            ?>
            <div class="detail-row">
                <div class="detail-label">Title :</div>
                <div class="detail-value"><?php echo $row[0]->title;?></div>
            </div>
            <div class="detail-row">
                <div class="detail-label">Agent :</div>
                <div class="detail-value"><?php echo $this->Internal_model->get_col_by_key('users','id',$row[0]->agent_id,'first_name');?></div>
            </div>
            <div class="detail-row">
                <div class="detail-label">Agent Commission :</div>
                <div class="detail-value"><?php echo $row[0]->agent_commission;?></div>
            </div>
            <div class="detail-row">
                <div class="detail-label">Manager Name :</div>
                <div class="detail-value"><?php echo $this->Internal_model->get_col_by_key('users','id',$row[0]->manager_id,'first_name');?></div>
            </div>
            <div class="detail-row">
                <div class="detail-label">Location :</div>
                <div class="detail-value"><?php echo $row[0]->location;?></div>
            </div>
            <div class="detail-row">
                <div class="detail-label">State :</div>
                <div class="detail-value"><?php echo $this->Internal_model->get_col_by_key('states','id',$row[0]->state_id,'name');?></div>
            </div>
            <div class="detail-row">
                <div class="detail-label">City :</div>
                <div class="detail-value"><?php echo $this->Internal_model->get_col_by_key('cities','id',$row[0]->city_id,'name');?></div>
            </div>
            <div class="detail-row">
                <div class="detail-label">Billing Type :</div>
                <div class="detail-value"><?php echo $row[0]->billing_type;?></div>
            </div>
            <div class="detail-row">
                <div class="detail-label">Amount :</div>
                <div class="detail-value"><?php echo $row[0]->amount;?></div>
            </div>
            <div class="detail-row">
                <div class="detail-label">Expenses :</div>
                <div class="detail-value"><?php echo $this->Internal_model->getTotalExpenses($row[0]->id);?></div>
            </div>
            <div class="detail-row">
                <div class="detail-label">Income :</div>
                <div class="detail-value"><?php echo $this->Internal_model->getTotalIncome($row[0]->id);?></div>
            </div>
            <div class="detail-row">
                <div class="detail-label">Due Amount :</div>
                <div class="detail-value"><?php echo $due_amount;?></div>
            </div>
            <!-- Adjust font size if needed -->
        </div>
        <button class="print-btn" onclick="printDetails()">Print</button>
    </div>

    <script>
        function printDetails() {
            var printContents = document.querySelector('.container').innerHTML;
            var originalContents = document.body.innerHTML;
            document.body.innerHTML = printContents;
            window.print();
            document.body.innerHTML = originalContents;
        }
    </script>
</body>
</html>
