<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Yaml\Exception\ParseException;
use Symfony\Component\Yaml\Yaml;

class OrganizationsController extends AbstractController
{
    public array $yaml;

    public function __construct()
    {
        $this->yaml = [];
        try
        {
            $this->yaml = Yaml::parseFile('../data/organizations.yaml');
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

    #[Route('/organizations/add', name: 'app_organizations_edit', methods: ['GET'])]
    public function add() : Response
    {
        return $this->render('organizations/add.html.twig');
    }

    #[Route('/organizations/edit/{name}', name: 'app_organizations_edit', methods: ['GET'])]
    public function edit(string $name) : Response
    {
        return $this->render('organizations/edit.html.twig', [
            'name' => $name,
            'data' => $this->findData($name),
        ]);
    }

    #[Route('/organizations/delete/{name}', name: 'app_organizations_delete', methods: ['GET'])]
    public function delete(string $name) : Response
    {
        return $this->render('organizations/delete.html.twig', [
            'name' => $name,
        ]);
    }

    private function findData($name)
    {
        $ret = [];
        for ($i = 0; $i < count($this->yaml); $i++)
        {
            if ($this->yaml["organizations"][$i]["name"] == $name)
            {
                $ret = $this->yaml["organizations"][$i];
            }
        }

        return $ret;
    }

}
