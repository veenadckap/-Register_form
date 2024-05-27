
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <title>Register</title>
    <style>
    body{
        background-color: #EACECE;
    }
        .head {
            background-color: #B8AAAA;
            border: 5px solid #B8AAAA;
        }

        .login-btn{
            position: relative;
            bottom: 22px;
            right:20px;
        }
    
        .btn{
            background-color: #F2A54A;
           width: 15%;
           height: 60px;
          
        }
    </style>
</head> 

<body>
    <?php include "./partial/nav.php";?>
       

        <div class="main pl-[10%] flex justify-center flex-col">
        <div class="two_div  pt-40">
                <div class="container text-center">
                    <p>Dear learners summary courses registration are available now.Please enrol if not already.</p>     
                </div>
                <div class="text-center pt-10">
             
                <a href="./register.php"><button class="btn">Register Now</button></a>
                
               </div>
            </div>     
         
         
         </div>

</body>

</html>
