<?php declare(strict_types=1);

namespace App\Controller;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class ApiController
{
    /**
     * @Route("/dhlfake.com/register", name="dhl_parcel_registration", methods={"POST"})
     *
     * @return JsonResponse
     */
    public function dhlParcelRegistrationAction(): JsonResponse
    {
        return new JsonResponse(['success' => true], 200);
    }

    /**
     * @Route("/omnivafake.com/pickup/find", name="omniva_pickup_find", methods={"GET"})
     *
     * @return JsonResponse
     */
    public function omnivaPickupPointAction(): JsonResponse
    {
        return new JsonResponse(['pickup_point_id' => rand(1, 20)], 200);
    }

    /**
     * @Route("/omnivafake.com/register", name="omniva_parcel_registration", methods={"POST"})
     *
     * @return JsonResponse
     */
    public function omnivaParcelRegistrationAction(): JsonResponse
    {
        return new JsonResponse(['success' => true], 200);
    }

    /**
     * @Route("/upsfake.com/register", name="ups_parcel_registration", methods={"POST"})
     *
     * @return JsonResponse
     */
    public function upsParcelRegistrationAction(): JsonResponse
    {
        return new JsonResponse(['success' => true], 200);
    }
}
