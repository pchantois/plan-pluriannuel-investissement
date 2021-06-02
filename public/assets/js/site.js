jQuery.fn.dataTable.Api.register( 'soutraction()', function ( ) {
  return this.flatten().reduce( function ( a, b ) {
      if ( typeof a === 'string' ) {
          a = a.replace(/[^\d.-]/g, '') * 1;
      }
      if ( typeof b === 'string' ) {
          b = b.replace(/[^\d.-]/g, '') * 1;
      }

      return (a - b);
  }, 0 );
} );

$(document).ready(function() {

  
  $('#ppi_global').DataTable({
    "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
    // "scrollY": "300px",
    // "scrollX": true,
    // "scrollCollapse": true,
    // "fixedColumns": {
    //   leftColumns: 3,
    //   rightColumns: 1,
    //   heightMatch: 'none'
    // },
    "paging": true,
    // "autoWidth": true,
    "footerCallback": function ( row, data, start, end, display ) {
      var api = this.api();
      nb_cols = api.columns().nodes().length;
      var j = 1;
      while(j < nb_cols){
        var pageTotal = api
              .column( j, { page: 'current'} )
              .data()
              .reduce( function (a, b) {
                  return Number(a) + Number(b);
              }, 0 );
        // Update footer
        $( api.column( j ).footer() ).html(pageTotal);
        j++;
      } 
    }
  //   columns: [
  //     { data: "dep.2020", render: $.fn.dataTable.render.number( ',', '.', 0, '$' ) }
  //   ]
  });

  
  $('#recueil_estimation').DataTable({
    "searching": false,
    "info": false,
    "paging": false,
    "bSort": false
  });
} );