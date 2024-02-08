<?php

namespace App\Controller;

use Core\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class OpensslController extends AbstractController
{
    private string $project_dir;

    public function __construct()
    {
        $this->project_dir = dirname($_SERVER['DOCUMENT_ROOT']);
    }

    public function index(Request $request): Response
    {

        if($request->getMethod() == "POST") {
            $message = $request->request->get('message');
            $strKey = file_get_contents($this->project_dir."/var/id_rsa");
            $privateKey = openssl_pkey_get_private($strKey, "commentestvotreblanquette");

            // https://www.php.net/manual/fr/function.openssl-private-encrypt.php#119810
            $status = openssl_private_encrypt($message, $crypted, $privateKey);
            if(!$status) {
                throw new \RuntimeException(openssl_error_string());
            }

            file_put_contents($this->project_dir."/var/secret", $crypted);

            $request->getSession()->getFlashBag()->add("success", "Le message a bien été enregistré");

            return new RedirectResponse("/openssl");
        }

        return $this->render('openssl/index');
    }

    public function decode(): Response
    {
        $decrypted = null;

        if(file_exists($this->project_dir."/var/secret")) {
            $secret = file_get_contents($this->project_dir."/var/secret");
            $publicKey = file_get_contents($this->project_dir."/var/id_rsa.pub");

            $status = openssl_public_decrypt($secret, $decrypted, $publicKey);
            if(!$status) {
                throw new \RuntimeException(openssl_error_string());
            }
        }

        return $this->render('openssl/decode', [
            'message' => $decrypted
        ]);
    }

    public function generateKeys(): Response
    {
        $passphrase = "commentestvotreblanquette";
        $config = [
            'private_key_bits' => 2048,
            'private_key_type' => OPENSSL_KEYTYPE_RSA,
            // 'config' => 'C:/wamp64/bin/php/phpx.x.x/extras/ssl/openssl.cnf',
        ];

        // Configure et crée la clé privé en mémoire
        $resource = openssl_pkey_new($config);

        // export de la clé privé
        $status = openssl_pkey_export($resource, $privateKey, $passphrase, $config);
        if(!$status) {
            throw new \RuntimeException(openssl_error_string());
        }
        file_put_contents($this->project_dir . "/var/id_rsa", $privateKey);

        // export de la clé public
        $arrayKey = openssl_pkey_get_details($resource);
        /*echo "<pre>";
        var_dump($arrayKey);*/
        file_put_contents($project_dir . "/var/id_rsa.pub", $arrayKey['key']);

        return new Response();
    }
}
