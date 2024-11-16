<?php
session_start();

$name = $organization = $email = $contact = $message = "";
$nameErr = $organizationErr = $emailErr = $contactErr = $messageErr = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $isValid = true;

    if (empty($_POST["name"])) {
        $nameErr = "Name is required";
        $isValid = false;
    } elseif (!preg_match("/^[a-zA-Z\s'-]+$/", $_POST["name"])) {
        $nameErr = "Name can only contain letters, spaces";
        $isValid = false;
    } else {
        $name = htmlspecialchars($_POST["name"]);
    }
    
    if (empty($_POST["organization"])) {
        $organizationErr = "Organization Name is required";
        $isValid = false;
    } elseif (!preg_match("/^[a-zA-Z\s'-]+$/", $_POST["organization"])) {
        $organizationErr = "Organization Name can only contain letters, spaces";
        $isValid = false;
    } else {
        $organization = htmlspecialchars($_POST["organization"]);
    }

    if (empty($_POST["email"])) {
        $emailErr = "Email is required";
        $isValid = false;
    } elseif (!filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)) {
        $emailErr = "Invalid email format";
        $isValid = false;
    } else {
        $email = htmlspecialchars($_POST["email"]);
    }

    if (empty($_POST["contact"])) {
        $contactErr = "Contact Number is required";
        $isValid = false;
    } elseif (!preg_match('/^[0-9]{10}$/', $_POST["contact"])) {
        $contactErr = "Invalid contact number format";
        $isValid = false;
    } else {
        $contact = htmlspecialchars($_POST["contact"]);
    }

    if (empty($_POST["message"])) {
        $messageErr = "Message is required";
        $isValid = false;
    } else {
        $message = htmlspecialchars($_POST["message"]);
    }

    if ($isValid) {

        $_SESSION['successMsg'] = "Form submitted successfully!";

        $name = $organization = $email = $contact = $message = "";

        header("Location: " . $_SERVER["PHP_SELF"]);
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Form</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <style>
        .contact-form-container {
            background-color: #ffffff;
            border-radius: 12px;
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
            padding: 40px;
            display: flex;
            gap: 20px;
            flex-wrap: wrap;
        }

        .contact-info {
            flex: 1;
            max-width: 350px;
            display: flex;
            flex-direction: column;
            text-align: left;
        }

        .contact-form {
            flex: 2;
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
            width: 100%;
        }

        .contact-form h2 {
            font-size: 1.75rem;
            font-weight: 600;
            color: #333;
        }

        .contact-form p {
            color: #666;
            font-size: 1rem;
            margin-bottom: 24px;
        }

        .form-control {
            border: none;
            border-bottom: 1px solid #ccc;
            border-radius: 0;
            padding: 10px;
        }

        .form-control:focus {
            border-color: #007bff;
            box-shadow: none;
        }

        .submit-btn {
            background-color: #007bff;
            color: #fff;
            border-radius: 20px;
            padding: 10px 30px;
        }

        .submit-btn:hover {
            background-color: #0056b3;
        }

        @media (max-width: 768px) {
            .contact-form-container {
                padding: 20px;
                flex-direction: column;
            }

            .contact-info {
                max-width: none;
                text-align: center;
                margin-bottom: 20px;
            }

            .contact-form {
                grid-template-columns: 1fr;
            }

            .submit-btn {
                padding: 8px 24px;
            }
        }

        @media (max-width: 480px) {
            .submit-btn {
                padding: 6px 18px;
            }
        }

        .alert-success {
            background-color: #d4edda;
            color: #155724;
            border-color: #c3e6cb;
            padding: 12px;
            border-radius: 4px;
            font-size: 1rem;
        }

        .explore-card {
            height: 120px;
            background-size: cover;
            background-position: center;
            display: flex;
            flex-direction: column;
            justify-content: flex-end; 
            align-items: center; 
            color: white;
            font-weight: bold;
            border-radius: 8px;
            padding: 10px;
        }

        .explore-card p {
            background: rgba(0, 0, 0, 0); 
            padding: 5px 10px;
            border-radius: 5px;
        }

        @media (max-width: 768px) {
            .contact-form-container {
                padding: 20px;
            }
            .contact-form h2 {
                font-size: 1.5rem;
            }
            .submit-btn {
                padding: 8px 24px;
            }
            .contact-info {
                max-width: none;
            }
            .contact-form {
                grid-template-columns: 1fr;
            }
        }

        @media (max-width: 480px) {
            .submit-btn {
                padding: 6px 18px;
            }
            .explore-card {
                height: 100px;
            }
            .explore-card p {
                font-size: 0.9rem;
            }
        }
    </style>

    <script>
        function hideSuccessMessage() {
            const successMessage = document.getElementById("successMessage");
            if (successMessage) {
                setTimeout(() => {
                    successMessage.style.display = "none";
                }, 5000);
            }
        }
    </script>
</head>

<body onload="hideSuccessMessage()">
    <div class="flex items-start">
        <img src="images/Logo.png" alt="Logo" class="w-22 h-20 mb-2 ml-20"> 
    </div>
    
    <div class="container mx-auto py-4 flex justify-center">
        <div class="contact-form-container max-w-4xl w-full p-4">
            
            <div class="contact-info">
                <h2 class="text-lg font-semibold">Got any questions?</h2>
                <p class="text-sm">Let’s discuss it over a cup of coffee.</p>
            </div>

            <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" class="contact-form w-full">
                <div>
                    <input type="text" name="name" value="<?php echo $name; ?>" placeholder="Name" class="form-control" required>
                    <span class="error text-danger"><?php echo $nameErr; ?></span>
                </div>

                <div>
                    <input type="text" name="organization" value="<?php echo $organization; ?>" placeholder="Organization Name" class="form-control">
                    <span class="error text-danger"><?php echo $organizationErr; ?></span>
                </div>

                <div>
                    <input type="email" name="email" value="<?php echo $email; ?>" placeholder="Email ID" class="form-control" required>
                    <span class="error text-danger"><?php echo $emailErr; ?></span>
                </div>

                <div>
                    <input type="text" name="contact" value="<?php echo $contact; ?>" placeholder="Contact Number" class="form-control">
                    <span class="error text-danger"><?php echo $contactErr; ?></span>
                </div>

                <div class="col-span-2">
                    <textarea name="message" placeholder="Message" class="form-control" rows="3"><?php echo $message; ?></textarea>
                    <span class="error text-danger"><?php echo $messageErr; ?></span>
                </div>

                <div class="col-span-2 flex justify-end">
                    <button type="submit" class="submit-btn px-4 py-2">Submit →</button>
                </div>

                <?php if (isset($_SESSION['successMsg'])): ?>
                    <div id="successMessage" class="alert alert-success w-full text-center mt-3">
                        <?php 
                            echo $_SESSION['successMsg']; 
                            unset($_SESSION['successMsg']);
                        ?>
                    </div>
                <?php endif; ?>
            </form>
        </div>
    </div>

   <head>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>

<section class="py-0 px-0">
    <div class="container mx-auto">
        <div class="relative w-full" style="height: 400px;">
            <iframe class="w-full h-full"
                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3770.785876563261!2d73.0044389!3d19.1433969!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3be7bfeb4288ae8d%3A0x8b330290504e58fa!2sLaser%20Technologies%20Pvt%20Ltd!5e0!3m2!1sen!2sin!4v1700000000000!5m2!1sen!2sin"> -->
            </iframe>
            <div class="absolute bottom-3 left-6 bg-blue-900 text-white p-6 rounded-lg shadow-lg max-w-sm">
                <h3 class="text-lg font-semibold mb-2">OneStopNDT</h3>
                <p class="text-sm mb-1">PAP/R/406 Rabale MIDC Near Dol Electric Company</p>
                <p class="text-sm mb-1">Rabale MIDC, Navi Mumbai - 400701</p>
                <p class="text-sm mb-3">Landline: 022 4313 0099</p>
                
                <a href="https://www.google.com/maps/place/Laser+Technologies+Pvt+Ltd/@19.1433969,73.0044389,791m/data=!3m2!1e3!4b1!4m6!3m5!1s0x3be7bfeb4288ae8d:0x8b330290504e58fa!8m2!3d19.1433969!4d73.0070138!16s%2Fg%2F1tks4syy?entry=ttu&g_ep=EgoyMDI0MTExMi4wIKXMDSoASAFQAw%3D%3D" 
                    target="_blank" 
                    class="text-blue-200 underline text-sm flex items-center space-x-2">
                    <i class="fas fa-map-marker-alt"></i>
                    <span>Google Map Link</span>
                </a>                
            </div>
        </div>
    </div>
</section>


<section class="container mt-2">
    <h3 class="text-2xl font-semibold mb-4">Explore</h3> 
    <div class="row text-center">
        <div class="col-md-2">
            <div class="explore-card" style="background-image: url('images/Company.jpg');">
                <p>Companies</p>
            </div>
        </div>
        <div class="col-md-2">
            <div class="explore-card" style="background-image: url('images/jobs.jpg');">
                <p>Jobs</p>
            </div>
        </div>
        <div class="col-md-2">
            <div class="explore-card" style="background-image: url('images/articles.jpg');">
                <p>Articles</p>
            </div>
        </div>
        <div class="col-md-2">
            <div class="explore-card" style="background-image: url('images/webinars.jpg');">
                <p>Webinars</p>
            </div>
        </div>
        <div class="col-md-2">
            <div class="explore-card" style="background-image: url('images/forums.jpg');">
                <p>Forums</p>
            </div>
        </div>
        <div class="col-md-2">
            <div class="explore-card" style="background-image: url('images/application_notes.jpg');">
                <p>Application Notes</p>
            </div>
        </div>
    </div>
</section>
    <footer class="py-4 mt-5" style="background-color: #1E3A8A; color: white;">
        <div class="container">
            <div class="d-flex justify-content-end">
                <img src="images/footer-logo.png" alt="Footer Logo" width="100">
            </div>
            <hr style="border-color: white;">
            <div class="d-flex justify-content-start">
                <p>What is One Stop NDT?</p>
            </div>
        </div>
    </footer>
</body>
</html>
