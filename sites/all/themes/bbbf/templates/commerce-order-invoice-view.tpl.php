<html>
  <head>
    <meta http-equiv="Content-Type" content="text/html;charset=utf-8" />
  </head>
  <body>
 <h1>BB Blues Fest</h1>
 <h2>Confirmação de pagamento<h2>
 <p><b>Encomenda: </b><?php print $info['order_number']; ?> (<?php print date('j F, Y', $info['order_created']); ?>)</p>
<p><b>Dados de pagamento:</b></p>
<p><?php print isset($info['customer_billing']) ? $info['customer_billing'] : ''; ?></p>
<p><b>Detalhe da compra:</b></p>
<?php print isset($info['line_items']) ? $info['line_items'] : ''; ?>
<div class="total"><?php print isset($info['order_total']) ? $info['order_total'] : ''; ?></div>
<p>Obrigado pela sua compra. Poderá levantar os seus bilhetes nos dias do Festival no Auditório José Manuel Figueiredo, mediante a apresentação desta confirmação.</p>
<p>Contacte-nos caso tenha alguma dúvida.</p>

  </body>
</html>
