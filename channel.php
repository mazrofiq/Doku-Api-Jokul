 <?php
require_once('DOKU/Client.php');

$DOKUClient = new DOKU\Client;
// Set your Client ID
$DOKUClient->setClientID($_POST['clientid']);
// Set your Shared Key
$DOKUClient->setSharedKey($_POST['secretkey']);
// Call this function for production use
$DOKUClient->isProduction($_POST['environment']);

$params = array(
    'customerEmail' => 'rafik@doku.com',
    'customerName' => 'rafik',
    'amount' => $_POST['amount'],
    'invoiceNumber' => $_POST['trans_id'],
    'ovo_id' => '081211111111',
    'expiryTime' => 120,
    'info1' => 'test',
    'info2' => 'test',
    'info3' => 'test',
    'reusableStatus' => 'false'
);




$channelVA='';

 switch ($_POST['channel']) {
    case 'JC':
            $channel = $DOKUClient->generateJC($params);
            $result = $channel['response']['payment']['url'];
            ?>

            <html>
                <head>
                    <meta name="viewport" content="width=device-width, initial-scale=1">
                    <script src="https://sandbox.doku.com/jokul-checkout-js/v1/jokul-checkout-1.0.0.js"></script>
                </head>
                <body>
                  <input type="hidden" id="wrap" value="<?php echo $result; ?>"/>
                    <script type="text/javascript">
                    var rpopup = document.getElementById("wrap").value ;
                        loadJokulCheckout(rpopup);
                    </script>
                </body>
            </html>

            <?php
        break;
    case 'CC':
            $channel = $DOKUClient->generateCrediCard($params);
            ?>
                <a href="<?php echo $channel['credit_card_payment_page']['url'] ?>" id="myLink" style ="display:none"></a>
                <script type="text/javascript">
                    function automateClick() {
                        document.getElementById('myLink').click()
                         }
                        window.addEventListener("load", automateClick);
                </script>
            <?php
        break;
    case 'MandiriVA':
            $channelVA = $DOKUClient->generateMandiriVa($params);
        break;
    case 'ovo':
            $channelOvo = $DOKUClient->generateOvo($params);
            ?>
            <!DOCTYPE html>
            <html lang="en" dir="ltr">
              <head>
                <meta charset="utf-8">
                <title>Payment Information</title>
                <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
              </head>
              <body>
                <div class="mx-auto container">
                  <div class="row">
                    <div class="col-md-6 offset-md-3">
                        <h1>Payment Information</h1>
                        <table class="table">
                          <tr>
                            <td>Invoice Number</td>
                            <td><?php echo $channelOvo['order']['invoice_number'] ?></td>
                          </tr>
                          <tr>
                            <td>Status</td>
                            <td><?php echo $channelOvo['ovo_payment']['status'] ?></td>
                          </tr>
                          <tr>
                            <td>Amount</td>
                            <td><?php echo $channelOvo['order']['amount'] ?></td>
                          </tr>
                          <tr>
                            <td><a class="btn btn-primary" href="http://localhost/jokul/" role="button">Back</a> </td>
                          </tr>
                        </table>
                    </div>
                  </div>
                </div>
                <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
                <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
                <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
              </body>
            </html>
            <?php
        break;
    default:
            $channelVA = $DOKUClient->generateBcaVa($params);
}


if(isset($channelVA['virtual_account_info']['virtual_account_number'])){

 ?>
 <!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Payment Information</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
  </head>
  <body>
    <div class="mx-auto container">
      <div class="row">
        <div class="col-md-6 offset-md-3">
            <h1>Payment Information</h1>
            <table class="table">
              <tr>
                <td>Invoice Number</td>
                <td><?php echo $channelVA['order']['invoice_number'] ?></td>
              </tr>
              <tr>
                <td>Payment Code</td>
                <td><?php echo $channelVA['virtual_account_info']['virtual_account_number'] ?></td>
              </tr>
              <tr>
                <td>Expired</td>
                <td><?php echo $channelVA['virtual_account_info']['expired_date'] ?></td>
              </tr>
              <tr>
                <td><a target="_blank" class="btn btn-primary" href="<?php echo $channelVA['virtual_account_info']['how_to_pay_page'] ?>" role="button">How to Pay</a> </td>
                 <td><a class="btn btn-primary" href="http://localhost/jokul/" role="button">Back</a> </td>
              </tr>
            </table>
        </div>
      </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
  </body>
</html>

<?php } ?>
