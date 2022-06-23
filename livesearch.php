<!DOCTYPE html>
 <html lang="en">
 <head>
  <meta charset="UTF-8">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
  <title>js-tutorials.com : live json search</title>
</head>
<body>
  <div class="container" style="padding:50px 250px;">
    <h1>Live LOL</h1>
	<form role="form">
        <div class="form-group">
          <input type="input" class="form-control input-lg" id="txt-search" placeholder="Type your search character">
        </div>
	</form>
	<div id="filter-records"></div>
  </div>
</body>
</html>
<script type="text/javascript">
  $(document).ready(function(){

    
    Promise.all([
  fetch('/wp-content/plugins/amosearch/products.txt').then(x => x.text())
]).then(([sampleResp]) => {
  var obj;
  obj = sampleResp;
  // console.log(obj);

    // fetch('/wp-content/plugins/amosearch/products.txt').then(results => results.json()).then(res => obj = res);

  // fetch('/wp-content/plugins/amosearch/products.txt').then(results => results.json()).then(res => obj = res)

  var data = [];

  var datar = decodeURI(obj);

  var dataArr = datar.split("|");
  
  dataArr.forEach(e => {toString(e);});
  
// BUG, try -1 : 
  for(var i = 0; i <= (dataArr.length - 2) ; i++){
    var temp = JSON.parse(dataArr[i]);
    data.push(temp);

    
  }
   
  

  



    

    $('#txt-search').keyup(function(){
            var searchField = $(this).val();
			if(searchField === '')  {
				$('#filter-records').html('');
				return;
			}
			
            var regex = new RegExp(searchField, "i");
            var output = '<div class="row">';
            var count = 1;
			  $.each(data, function(key, val){
				if ((val.product.id.search(regex) != -1) || (val.product.title.search(regex) != -1)) {
          output += `<a href="${val.product.link} target="_blank">"`;
				  output += `<div class="col-md-6 well" >`;
				  output += '<div class="col-md-3"><img class="img-responsive" src="'+val.product.title+'" alt="'+ val.product.title +'" /></div>';
				  output += '<div class="col-md-7">';
				  output += '<h5>' + val.product.title + '</h5>';
				  output += '<p>' + val.price + '</p>'
				  output += '</div></a>';
				  output += '</div>';
				  if(count%2 == 0){
					output += '</div><div class="row">'
				  }
				  count++;
				}
			  });
			  output += '</div>';
			  $('#filter-records').html(output);
        })});
  });
</script>