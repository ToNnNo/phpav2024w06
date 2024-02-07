<?php

namespace App\Controller;

use App\Pattern\Adapter\OriginalProduct;
use App\Pattern\Adapter\ProductAdapter;
use App\Pattern\Builder\MysqlQueryBuilder;
use App\Pattern\Composite\Form;
use App\Pattern\Composite\Input;
use App\Pattern\Composite\Submit;
use App\Pattern\Factory\ParserFactory;
use App\Pattern\Singleton\Mayor;
use App\Pattern\Strategy\FileWriter;
use App\Pattern\Strategy\Formatter\HTMLFormatter;
use App\Pattern\Strategy\Formatter\TextFormatter;
use Core\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class PatternController extends AbstractController
{

    public function index(): Response
    {

        return $this->render('pattern/index');
    }

    public function singleton(): Response
    {
        $mayor1 = Mayor::getInstance();
        $mayor1->setName("John Doe");

        $mayor2 = Mayor::getInstance();
        $mayor2->setName("Wilson Fisk");

        return $this->render('pattern/singleton', [
            'mayor1' => $mayor1,
            'mayor2' => $mayor2,
        ]);
    }

    public function factory(): Response
    {
        $jsonContent = '{"firstname":"John", "lastname": "Doe"}';
        $yamlContent = <<<YAML
firstname: Wilson
lastname: Fisk
YAML;

        $parser = new ParserFactory();
        $jsonData = $parser->parse($jsonContent, 'json');
        // $yamlData = $parser->parse($jsonContent, 'yaml');

        return $this->render('pattern/factory', [
            'jsonData' => $jsonData
        ]);
    }

    public function strategy(Request $request): Response
    {
        $dateFormatter = new \IntlDateFormatter('FR_fr');
        // $dateFormatter->setTimeZone("Pacific/Tahiti");
        $date = $dateFormatter->format(new \DateTime());


        $path = dirname(getcwd()) . "/var/file/dev.txt";
        $pathHTML = dirname(getcwd()) . "/var/file/dev.html";

        $writer = new FileWriter(new TextFormatter(), $path);
        $writer->write("Hello World");

        $htmlwriter = new FileWriter(new HTMLFormatter(), $pathHTML);
        $htmlwriter->write("Hello HTML");

        return $this->render('pattern/strategy', [
            'date' => $date
        ]);
    }

    public function adapter(): Response
    {
        $originalProduct = new OriginalProduct("Pomme", 9.99, 10);

        $productAdapter = new ProductAdapter($originalProduct);
        $product = $productAdapter->adapt();

        return $this->render("pattern/adapter", [
            'product' => $product
        ]);
    }

    public function builder(): Response
    {
        $queryBuilder = new MysqlQueryBuilder("client");
        $query = $queryBuilder
            ->select(['id', 'firstname', 'lastname'])
            ->select(['email', 'phone'])
            ->where('department = :department')
            ->limit(0, 100)
            ->getQuery();

        $qb = new MysqlQueryBuilder("client");
        $q = $qb
            ->getQuery();

        return $this->render('pattern/builder', [
            'query' => $query,
            'base' => $q
        ]);
    }

    public function composite(Request $request): Response
    {
        $form = new Form("registrer");
        $formView = $form
            ->add(new Input("firstname", ['label' => "Prénom : "]))
            ->add(new Input("lastname", ['label' => "Nom : "]))
            ->add(new Submit("send", [
                'type' => "submit",
                'value' => "Envoyer"
            ]))
            ->render();

        if ($request->getMethod() == "POST") {
            var_dump($request->request->all());
        }


        return $this->render('pattern/composite', [
            'form' => $formView
        ]);
    }
}
