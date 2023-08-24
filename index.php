<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
     <style type="text/css">
        #loading {
          width: 50px;
          height: 50px;
          border: solid 5px #ccc;
          border-top-color: #ff6a00;
          border-radius: 100%;
          position: fixed;
          left: 0;
          top: 0;
          right: 0;
          bottom: 0;
          margin: auto;
          animation: putar 2s linear infinite;
          display: none;
          }
          @keyframes putar{
            from{transform:rotate(0deg)}
            to{transform:rotate(360deg)}
        }
        #howtoOvo{
          display: none;
        }
      </style>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
    <meta charset="utf-8">
    <title>JOKUL SAMPEL TESTING</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
  </head>
  <body>
    <div id ="loading"></div>
    <div class="mx-auto container">
      <div class="row">
        <div class="col-md-6 offset-md-3">
          <form id ="tutup" method="post" action="channel.php">
            <h1>JOKUL TESTING</h1>
            <table class="table">

              <tr>
                <td>clientId</td>
                <td><input type="text" name="clientid" value="BRN-0283-1659664517680"></td>
              </tr>
              <tr>
                <td>secretkey</td>
                <td><input type="text" name="secretkey" value="SK-olOoLkVVfcn7oLNqrlgG"></td>
              </tr>
              <tr>
                <td>Invoice</td>
                <td><input type="text" name="trans_id" id ="invo" value="<?php echo 'INV-'. time()?>" required /></td>
              </tr>
              <tr>
                <td>Amount</td>
                <td><input type="text" name="amount" value="2000"></td>
              </tr>
              <tr>
                <td>Environment</td>
                <td><select name="environment">
                    <option value="false">Development</option>
                    <option value="true">Production</option>
                    </select>
                </td>
              </tr>
              <tr>
                <td>Payment channel</td>
                <td><select name="channel" id = "pilih">
                    <option value="JC">Jokul Checkout</option>
                    <option value="MandiriVA">Mandiri VA</option>
                    <option value="BRIVA">BRI VA</option>
                    <option value="PermataVA">Permata VA</option>
                    <option value="BCAVA">BCA VA</option>
                    <option value="CC">Credit Card</option>
                    <option value="ovo">OVO</option>
                    </select>
                </td>
              </tr>
              
              <tr>
                <td><button id="checkout-button" type="submit" class="btn btn-success" name="button">Kirim</button></td>
              </tr>
            </table>
          </form>
              <div id ="howtoOvo">
                <h1>Payment Information</h1>
                <table class="table">
                  <tr>
                    <td>Invoice Number</td>
                    <td id = "inv"></td>
                  </tr>
                  <tr>
                    <td>Klik this <a href="https://sandbox.doku.com/integration/simulator/ovo/inquiry" target="_blank"> link </a> to pay on the simulator</td>
                  </tr>
                </table>
              </div>
        </div>
      </div>
    </div>
    <script type="text/javascript">
      $(document).ready(function(){
        $('#checkout-button').click(function(){
          $('#tutup').css('display','none');
          $('#loading').css('display','block');
          var pilih = $('#pilih').val();
          if (pilih == 'ovo'){
            $('#howtoOvo').css('display','block');
            var invoi = $('#invo').val();
                $('#inv').html(invoi);
          }
        });
      });
    </script>
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
  </body>
</html>
