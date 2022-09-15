<?php

namespace App\Controller;

use App\Entity\Organization;
use App\Entity\Users;
use App\Form\Type\OrganizationType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Yaml\Exception\ParseException;
use Symfony\Component\Yaml\Yaml;

class OrganizationsController extends AbstractController
{
    private string $fileName = "../data/organizations.yaml";
    public array $yaml;

    public function __construct()
    {
        $this->yaml = [];
        try
        {
            $this->yaml = Yaml::parseFile($this->fileName);
        }
        catch (ParseException $exception)
        {
            printf('Unable to parse the YAML string: %s', $exception->getMessage());
        }
    }

    #[Route('/organizations', name: 'app_organizations')]
    public function index() : Response
    {
        return $this->render('organizations/index.html.twig', [
            'yaml' => $this->yaml,
        ]);
    }

    #[Route('/organizations/add', name: 'app_organizations_add', methods: [
        'GET',
        'POST',
    ])]
    public function add(Request $request) : Response
    {
        if ($request->isMethod('POST'))
        {
            // we will not use this because posting arrays is removed and we dont use any databases.
            // $form = $this->createForm(OrganizationType::class, $organization);
            $post = $request->request->all()["organization"];

            $org = new Organization();
            $org->setName($post["name"]);
            $org->setDescription($post["description"]);

            // normally multiple users can be added from frontend side but this is just an sample project
            $user = new Users();
            $user->setName($post["users"]["name"]);
            $user->setRole($post["users"]["roles"]); // we can create a new object here but not necessary at the moment
            $user->setPassword($post["users"]["password"]);
            $user_array[] = $user;
            $org->setUsers($user_array);

            $this->yaml["organizations"][] = json_decode(json_encode($org), true);
            $yaml = Yaml::dump($this->yaml);
            file_put_contents($this->fileName, $yaml);

            // $form->submit($request->request->get($form->getName()));

            return $this->redirectToRoute('app_organizations');
        }
        else
        {
            // $form = $this->createFormBuilder($organization)->add('name', TextType::class, ['label' => 'Name of the Organization: '])->add('save', SubmitType::class, ['label' => 'Submit'])->getForm();
            $organization = new Organization();
            $form = $this->createForm(OrganizationType::class, $organization);

            return $this->renderForm('organizations/add.html.twig', [
                'form' => $form,
            ]);
        }
    }

    #[Route('/organizations/edit/{name}', name: 'app_organizations_edit', methods: [
        'GET',
        'POST',
    ])]
    public function edit(Request $request, string $name) : Response
    {
        if ($request->isMethod('POST'))
        {
            $post = $request->request->all()["organization"];

            var_dump($post);
            $org = new Organization();
            $org->setName($post["name"]);
            $org->setDescription($post["description"]);
            $org->setUsers($post["users"]);

            // dd($org);

            $new_yaml = [];

            for ($i = 0; $i < count($this->yaml["organizations"]); $i++)
            {
                if ($this->yaml["organizations"][$i]["name"] != $name)
                {
                    $new_yaml[] = $this->yaml["organizations"][$i];
                }
            }
            $new_yaml[] = json_decode(json_encode($org), true);
            // dd($new_yaml);
            $this->yaml["organizations"] = $new_yaml;
            $yaml = Yaml::dump($this->yaml);
            file_put_contents($this->fileName, $yaml);

            return $this->redirectToRoute('app_organizations');
        }
        $data = $this->findData($name);
        if (is_array($data))
        {
            $organization = new Organization($data["name"], $data["description"], $data["users"]);
        }
        else
        {
            $organization = new Organization();
        }
        $form = $this->createForm(OrganizationType::class, $organization);

        // $form = $this->createFormBuilder($organization);
        return $this->renderForm('organizations/edit.html.twig', [
            'form' => $form,
            'name' => $name
        ]);
    }

    #[Route('/organizations/delete/{name}', name: 'app_organizations_delete', methods: ['GET'])]
    public function delete(string $name) : Response
    {
        if (is_array($this->findData($name)))
        {
            $new_yaml = [];

            for ($i = 0; $i < count($this->yaml["organizations"]); $i++)
            {
                if ($this->yaml["organizations"][$i]["name"] != $name)
                {
                    $new_yaml[] = $this->yaml["organizations"][$i];
                }
            }
            $this->yaml["organizations"] = $new_yaml;
            $yaml = Yaml::dump($this->yaml);
            file_put_contents($this->fileName, $yaml);
        }

        return $this->redirectToRoute('app_organizations');
        /*
        a confirmation page can be implemented
        return $this->render('organizations/delete.html.twig', [
            'name' => $name,
        ]);*/
    }

    private function findData($name)
    {
        $ret = [];
        for ($i = 0; $i < count($this->yaml["organizations"]); $i++)
        {
            if ($this->yaml["organizations"][$i]["name"] == $name)
            {
                $ret = $this->yaml["organizations"][$i];
                break;
            }
        }

        return $ret;
    }

}
