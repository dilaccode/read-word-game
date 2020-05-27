<!DOCTYPE html>
<html>

<head>
    <!-- mobile -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- w3css -->
    <link rel="stylesheet" href="/assets/css/w3.css">
    <!-- icon library -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <!--custome css-->
    <link rel="stylesheet" href="/assets/css/Core.css">
    <?php if(IsPhone()):?>
        <link rel="stylesheet" href="/assets/css/Phone.css">
    <?php else:?>
        <link rel="stylesheet" href="/assets/css/TabletAndPC.css">
    <?php endif;?>
    <!-- jquery -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <!-- custom script -->
    <script type="text/javascript" src="/assets/js/Core.js"></script>
    <script type="text/javascript" src="/assets/js/Player.js"></script>
    
    <!--icon-->
    <link rel="shortcut icon" type="image/png" href="/assets/images/favicon.png"/>
</head>