<?php require_once('php/_groups.php'); ?>
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
<title>Chinese Graded Fund Analysis Tools</title>
<meta name="description" content="Each of these tools estimates the net value of one Chinese graded fund and makes arbitrage analysis.">
<link href="../../common/style.css" rel="stylesheet" type="text/css" />
</head>

<body bgproperties=fixed leftmargin=0 topmargin=0>
<?php _LayoutTopLeft(false); ?>

<div>
<h1>Chinese Graded Fund Analysis Tools</h1>
<p>Each of these tools estimates the net value of one Chinese graded fund and makes arbitrage analysis.
<?php EchoGradedFundToolTable(false); ?>
</p>
<?php EchoPromotionHead('gradedfund', false); ?>
<p>Related software:
<?php EchoStockGroupLinks(false); ?>
</p>
</div>

<?php LayoutTailLogin(false); ?>

</body>
</html>