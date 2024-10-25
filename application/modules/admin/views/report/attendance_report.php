<div class="row">
  <?php $this->load->view('includes/collapseAddForm'); ?>
  
  <div class="col-12 grid-margin collapse show" id="collapseExample">
    <div class="card">
      <div class="card-body">
        <h4 class="card-title"><?php echo $page_title; ?></h4>
        <form class="form-sample" id="crudFormAddApiDataMultiple" action="<?php echo API_DOMAIN; ?>api/attendance_report/attendance_report/add" method="POST">
        </form>
      </div>
    </div>
  </div>
</div>

<div class="row">
  <input type="hidden" value="<?php echo API_DOMAIN; ?>api/attendance_report/attendance_report_list" id="list_end_point">
  <input type="hidden" value="<?php echo API_DOMAIN; ?>api/attendance_report/attendance_report/" id="delete_end_point">
  <input type="hidden" value="<?php echo API_DOMAIN; ?>api/attendance_report/attendance_report_details" id="show_endpoint">
  <input type="hidden" value="admin/manage_member/attendance_report_edit" id="edit_page_name">
  <div class="col-lg-12 grid-margin stretch-card">
    <div class="card">
      <div class="card-body">
        <h4 class="card-title"><?php echo $page_title; ?> <?php $this->load->view('includes/collapseFilterForm'); ?></h4>
        <div class="collapse show" id="collapseExampleFilter">
          <form id="filterForm">
            <div class="row">
              <div class="col-md-3 form-group">
                <select id="filterName" name="name" class="form-control">
                  <option value="">Select User</option>
                  <?php $getUser = $this->Internal_model->getUser();
                  foreach($getUser as $row){ ?>
                    <option value="<?php echo $row->users_id;?>"><?php echo $row->first_name;?></option>
                  <?php } ?>
                </select>
              </div>
              <div class="col-md-3 form-group">
                <select id="filterStatus" name="status" class="form-control">
                  <option value="">Select Status</option>
                  <option value="Absent">Absent</option>
                  <option value="Present">Present</option>
                  <option value="Half day">Half day</option>
                  <option value="Leave">Leave</option>
                </select>
              </div>
              <div class="col-md-3 form-group">
                <input type="date" id="filterFromDate" name="from_date" placeholder="From Date" class="form-control">
              </div>
              <div class="col-md-3 form-group">
                <input type="date" id="filterToDate" name="to_date" placeholder="To Date" class="form-control">
              </div>
              <div class="col-md-3 form-group">
                <label for="datePicker">Select Date:</label>
                <input type="month" id="datePicker" name="datePicker" class="form-control">
              </div>
              <div class="col-md-3 form-group">
                <?php $this->load->view('includes/filter_form_btn'); ?>
              </div>
            </div>
          </form>
        </div>
        <div class="table-responsive">
          <table class="table table-dark table-striped" >
            <thead id="dynamic_table_head">
              <tr>
                <th>#</th>
                <th>Employee Name</th>
              </tr>
            </thead>
            <tbody>
          <td></td>
          <td>sssss</td> 
          <td>dynamic date </td> 
          </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>


<script>
  function renderTableData() {
    return [
      { 
        "data": null, 
        "render": function(data, type, row, meta) {
          return meta.row + 1;
        }
      },
      { "data": "FirstName", "orderable": true },
      { "data": "status", "orderable": true },
      { 
        "data": null, 
        "render": function(data, type, row) {
          return renderOptionBtn(data, type, row);
        }
      }
    ];
  }

  function initializeTable() {
    const today = new Date();
    const month = today.getMonth() + 1;
    const year = today.getFullYear();
    generateTableHeaders(month, year);
    loadAttendanceData(month, year);
    renderTableData();
  }

  document.addEventListener('DOMContentLoaded', function() {
    initializeTable();

    document.getElementById('datePicker').addEventListener('change', function() {
      const selectedDate = new Date(this.value + '-01');
      const selectedMonth = selectedDate.getMonth() + 1;
      const selectedYear = selectedDate.getFullYear();
      generateTableHeaders(selectedMonth, selectedYear);
      loadAttendanceData(selectedMonth, selectedYear);
      
    });
  });

  // Function to get the number of days in a month
  function daysInMonth(month, year) {
    return new Date(year, month, 0).getDate();
  }

  function generateTableHeaders(month, year) {
    const days = daysInMonth(month, year);
    const headerRow = document.getElementById('dynamic_table_head').querySelector('tr');
    headerRow.innerHTML = '<th>#</th><th>Employee Name</th>'; // Reset the header

    for (let day = 1; day <= days; day++) {
      const th = document.createElement('th');
      th.textContent = `${day}/${month}/${year}`;
      th.setAttribute('data-date', `${year}-${month.toString().padStart(2, '0')}-${day.toString().padStart(2, '0')}`);
      headerRow.appendChild(th);
    }
  }

  function loadAttendanceData(month, year) {
    const listEndPoint = document.getElementById('list_end_point').value;
    fetch(`${listEndPoint}?month=${month}&year=${year}`)
      .then(response => response.json())
      .then(data => {
        populateTable(data);
      })
      .catch(error => console.error('Error fetching data:', error));
  }

  function populateTable(data) {
    const tableBody = document.getElementById('api_response_table_body');
    tableBody.innerHTML = '';

    data.forEach((item, index) => {
      const row = document.createElement('tr');

      const cellIndex = document.createElement('td');
      cellIndex.textContent = index + 1;
      row.appendChild(cellIndex);

      const cellName = document.createElement('td');
      cellName.textContent = item.FirstName;
      row.appendChild(cellName);

      const headerCells = document.querySelectorAll('#dynamic_table_head th[data-date]');
      headerCells.forEach(headerCell => {
        const date = headerCell.getAttribute('data-date');
        const cell = document.createElement('td');
        const attendanceRecord = item.attendance.find(record => record.date === date);
        cell.textContent = attendanceRecord ? attendanceRecord.status : 'Absent';
        row.appendChild(cell);
      });

      tableBody.appendChild(row);
    });
  }
</script>
