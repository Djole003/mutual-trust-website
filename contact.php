<?php include 'header.php'; ?>
<?php require 'config.php'; ?>

<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'phpmailer/src/PHPMailer.php';
require 'phpmailer/src/SMTP.php';
require 'phpmailer/src/Exception.php';

$success = false;
$error = "";

if($_SERVER["REQUEST_METHOD"] == "POST"){

$ime = htmlspecialchars($_POST["ime"] ?? '');
$email = htmlspecialchars($_POST["email"] ?? '');
$naslov = htmlspecialchars($_POST["naslov"] ?? '');
$poruka = htmlspecialchars($_POST["poruka"] ?? '');
$honeypot = $_POST["company"] ?? '';

if(!empty($honeypot)){
$error = "Spam detektovan.";
}

elseif(!filter_var($email, FILTER_VALIDATE_EMAIL)){
$error = "Neispravna email adresa.";
}

else{

$mail = new PHPMailer(true);

try{

$mail->CharSet = 'UTF-8';
$mail->isSMTP();

$mail->Host = 'smtp.gmail.com';
$mail->SMTPAuth = true;

$mail->Username = SMTP_USER;
$mail->Password = SMTP_PASS;

$mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
$mail->Port = 587;

$mail->SMTPOptions = [
'ssl' => [
'verify_peer' => false,
'verify_peer_name' => false,
'allow_self_signed' => true
]
];

$mail->setFrom(SMTP_USER,'Kontakt forma');
$mail->addAddress(SMTP_USER);
$mail->addReplyTo($email,$ime);

$mail->isHTML(true);

$mail->Subject = "Kontakt forma: $naslov";

$mail->Body = "
<h2 style='color:#333'>Nova poruka sa sajta</h2>

<p><strong>Ime:</strong> $ime</p>
<p><strong>Email:</strong> $email</p>
<p><strong>Naslov:</strong> $naslov</p>

<hr>

<p><strong>Poruka:</strong></p>
<p>$poruka</p>
";

$mail->send();



$reply = new PHPMailer(true);

$reply->CharSet = 'UTF-8';

$reply->isSMTP();
$reply->Host = 'smtp.gmail.com';
$reply->SMTPAuth = true;
$reply->Username = SMTP_USER;
$reply->Password = SMTP_PASS;
$reply->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
$reply->Port = 587;

$reply->setFrom(SMTP_USER,'Mutual Trust');
$reply->addAddress($email,$ime);

$reply->isHTML(true);

$reply->Subject = "Primili smo vašu poruku";

$reply->Body = "
<h2>Hvala što ste nas kontaktirali</h2>

<p>Poštovani $ime,</p>

<p>Vaša poruka je uspešno primljena.</p>

<p>Naš tim će vam odgovoriti u najkraćem mogućem roku.</p>

<hr>

<p>
📞 Telefon: +381 11 624 61 92<br>
📧 Email: kancelarijaagencija@gmail.com
</p>

<p>Srdačan pozdrav,<br>
Mutual Trust</p>
";

$reply->send();

$success = true;

}catch(Exception $e){

$error = $mail->ErrorInfo;

}

}

}

?>



<div id="success-popup" class="popup" data-show="<?php echo $success ? 'true' : 'false'; ?>">

<div class="popup-box">

<div class="popup-icon">✓</div>

<h3>Poruka je poslata</h3>

<p>Hvala vam na kontaktu. Odgovorićemo u najkraćem mogućem roku</p>

<button onclick="closePopup()">U redu</button>

</div>

</div>



<section class="contact-hero">

<div class="hero-overlay"></div>

<div class="container hero-content" data-aos="fade-up">
<h1>Kontakt – Knjigovodstvena agencija Mutual Trust</h1>
<p>Kontaktirajte nas za konsultaciju ili dodatne informacije</p>
</div>

</section>



<section class="contact-section">

<div class="container contact-grid">

<div class="contact-info" data-aos="fade-right">

<h2>Kontakt informacije</h2>

<div class="contact-item">
<h3>Email</h3>
<p>kancelarijagencija@gmail.com</p>
</div>

<div class="contact-item">
<h3>Telefon</h3>
<p>+381 11 624 61 92</p>
</div>

<div class="contact-item">
<h3>Adresa</h3>
<p>Ilije Stojadinovića, I sprat, stan 9</p>
<p>Beograd, Srbija</p>
</div>

<div class="contact-item">
<h3>Radno vreme</h3>
<p>Ponedeljak – Petak</p>
<p>09:00 – 17:00</p>
</div>

<div class="contact-item">
<h3>Podaci o firmi</h3>
<p>PIB: 112589612</p>
<p>Matični broj: 66213226</p>
</div>

<!-- SEO tekst -->

<div class="seo-contact-text">

<p>
Mutual Trust je knjigovodstvena agencija u Beogradu koja pruža profesionalne
usluge vođenja poslovnih knjiga, obračuna plata, poreskog savetovanja
i finansijskog izveštavanja za preduzetnike i kompanije.
</p>

<p>
Ako vam je potreban pouzdan knjigovođa u Beogradu,
kontaktirajte nas putem kontakt forme, telefona ili email adrese.
</p>

</div>

</div>



<div class="contact-form" data-aos="fade-left">

<h2>Pošaljite poruku</h2>

<p class="form-note">
Odgovaramo na sve upite u roku od 24h.
</p>

<?php if($error): ?>
<div class="form-error"><?php echo $error; ?></div>
<?php endif; ?>

<form method="POST">

<input type="text" name="ime" placeholder="Vaše ime" required>

<input type="email" name="email" placeholder="Email adresa" required>

<input type="text" name="naslov" placeholder="Naslov poruke">

<textarea name="poruka" placeholder="Vaša poruka" rows="5" required></textarea>

<input type="text" name="company" style="display:none">

<button type="submit" class="btn-gold submit-btn">

<span class="btn-text">Pošalji poruku</span>
<span class="spinner"></span>

</button>

<p class="privacy-note">
Vaši podaci su sigurni i koristiće se isključivo za odgovor na vaš upit.
</p>

</form>

</div>

</div>

</section>



<section class="map-section" data-aos="fade-up">

<iframe
src="https://www.google.com/maps?q=Ilije%20Stojadinovića%20Beograd%20Srbija&output=embed"
width="100%"
height="400"
style="border:0;"
allowfullscreen=""
loading="lazy">
</iframe>

</section>



<script type="application/ld+json">
{
 "@context": "https://schema.org",
 "@type": "AccountingService",
 "name": "Mutual Trust",
 "image": "https://mutualtrust.rs/assets/images/logo.png",
 "url": "https://mutualtrust.rs",
 "telephone": "+381116246192",
 "address": {
 "@type": "PostalAddress",
 "streetAddress": "Ilije Stojadinovića",
 "addressLocality": "Beograd",
 "addressCountry": "RS"
 },
 "areaServed": "Serbia",
 "description": "Knjigovodstvena agencija koja pruža vođenje poslovnih knjiga, obračun plata i poresko savetovanje."
}
</script>


<?php include 'footer.php'; ?>