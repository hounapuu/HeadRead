<?php
if (!session_id()) { //Check if facebook session is up, if not then start a new one
    session_start();
}
require_once __DIR__ . '/vendor/autoload.php';

use Sk\SmartId\Client;
use Sk\SmartId\Api\Data\NationalIdentity;
use Sk\SmartId\Api\Data\AuthenticationHash;
use Sk\SmartId\Api\Data\CertificateLevelCode;
use Sk\SmartId\Api\AuthenticationResponseValidator;
function alert($msg) {
    echo "<script type='text/javascript'>alert('$msg');</script>";
}
// Client setup. Note that these values are demo environment specific.
$client = new Client();
$client
    ->setRelyingPartyUUID( '00000000-0000-0000-0000-000000000000' )
    ->setRelyingPartyName( 'DEMO' )
    ->setHostUrl( 'https://sid.demo.sk.ee/smart-id-rp/v1/' );


// For security reasons a new hash value must be created for each new authentication request
// Consists of country and personal identity code

$idNumber = trim($_POST['idNumber']);
if ($idNumber == '' || strlen($idNumber)!=11) {
    header('Location: http://46.101.78.158/');
}
$identity = new NationalIdentity( 'EE', $idNumber );
// For security reasons a new hash value must be created for each new authentication request
$authenticationHash = AuthenticationHash::generate();

$verificationCode = $authenticationHash->calculateVerificationCode();
alert("Kontrollkood: " . $verificationCode);

try
{
    $authenticationResponse = $client->authentication()
        ->createAuthentication()
        ->withNationalIdentity( $identity ) // or with document number: ->withDocumentNumber( 'PNOEE-1111111111-XXXX-XX' )
        ->withAuthenticationHash( $authenticationHash )
        ->withCertificateLevel( CertificateLevelCode::QUALIFIED ) // Certificate level can either be "QUALIFIED" or "ADVANCED"
        ->authenticate();

}
catch (Exception $e){
    alert("Midagi läks valesti. Proovige hiljem uuesti.");
    echo "<script>window.location.href = '" . "http://46.101.78.158'</script>";
    // Handle exception (more on exceptions in "Handling intentional exceptions")
}

$authenticationResponseValidator = new AuthenticationResponseValidator();
$authenticationResult = $authenticationResponseValidator->validate( $authenticationResponse );
// authentication validity result
$isValid = $authenticationResult->isValid();

// When the result is not valid then the reason(s) for invalidity are obtainable like this:
$errors = $authenticationResult->getErrors();
if ($isValid==true) {
    $_SESSION['smartValid'] = true;
}
else{
    alert("Midagi läks valesti. Proovige hiljem uuesti.");
}
echo "<script>window.location.href = '" . "http://46.101.78.158'</script>";


