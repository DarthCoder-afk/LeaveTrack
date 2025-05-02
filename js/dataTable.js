
$(document).ready(function() {

  $.fn.dataTable.ext.type.order['date-mmm-dd-yyyy-pre'] = function(data) {

    const dateParts = data.split(' ');
    if (dateParts.length < 3) return 0; // Handle invalid dates
    
    
    const months = {
      'January': '01', 'February': '02', 'March': '03', 'April': '04',
      'May': '05', 'June': '06', 'July': '07', 'August': '08',
      'September': '09', 'October': '10', 'November': '11', 'December': '12'
    };
    

    const month = months[dateParts[0]];
    const day = dateParts[1].replace(',', '').padStart(2, '0');
    const year = dateParts[2];
    

    return `${year}${month}${day}`;
  };


  $('#dataTableHover').DataTable({
    // Define columns with types
    columnDefs: [
      { 
        type: 'date-mmm-dd-yyyy',
        targets: 4 
      }
    ],
  
    order: [[4, 'desc']],
    "language": {
      "emptyTable": "No leave applications found"
    }
  });
});