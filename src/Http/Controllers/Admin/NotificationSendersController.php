<?php

namespace Railken\Amethyst\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Railken\Amethyst\Api\Http\Controllers\RestManagerController;
use Railken\Amethyst\Api\Http\Controllers\Traits as RestTraits;
use Railken\Amethyst\Managers\DataBuilderManager;
use Railken\Amethyst\Managers\NotificationSenderManager;
use Symfony\Component\HttpFoundation\Response;

class NotificationSendersController extends RestManagerController
{
    use RestTraits\RestIndexTrait;
    use RestTraits\RestShowTrait;
    use RestTraits\RestCreateTrait;
    use RestTraits\RestUpdateTrait;
    use RestTraits\RestRemoveTrait;

    /**
     * The class of the manager.
     *
     * @var string
     */
    public $class = NotificationSenderManager::class;

    /**
     * @param int                      $id
     * @param \Illuminate\Http\Request $request
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function execute(int $id, Request $request)
    {
        /** @var \Railken\Amethyst\Managers\NotificationSenderManager */
        $manager = $this->manager;

        /** @var \Railken\Amethyst\Models\NotificationSender */
        $notification = $manager->getRepository()->findOneById($id);

        if ($notification == null) {
            return $this->response('', Response::HTTP_NOT_FOUND);
        }

        $result = $manager->send($notification, (array) $request->input('data'));

        if (!$result->ok()) {
            return $this->error(['errors' => $result->getSimpleErrors()]);
        }

        return $this->success([]);
    }

    /**
     * Render raw template.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function render(Request $request)
    {
        /** @var \Railken\Amethyst\Managers\EmailSenderManager */
        $manager = $this->manager;

        $dbm = (new DataBuilderManager());

        /** @var \Railken\Amethyst\Models\DataBuilder */
        $data_builder = $dbm->getRepository()->findOneById(intval($request->input('data_builder_id')));

        if ($data_builder == null) {
            return $this->error([['message' => 'invalid data_builder_id']]);
        }

        $data = (array) $request->input('data');

        $result = $dbm->build($data_builder, $data);

        if (!$result->ok()) {
            return $this->error(['errors' => $result->getSimpleErrors()]);
        }

        $data = array_merge($data, $result->getResource());

        if ($result->ok()) {
            $result = $manager->render(
                $data_builder,
                [
                    'title'   => strval($request->input('title')),
                    'message' => strval($request->input('message')),
                    'targets' => strval($request->input('targets')),
                    'options' => strval($request->input('options')),
                ],
                $data
            );
        }

        if (!$result->ok()) {
            return $this->error(['errors' => $result->getSimpleErrors()]);
        }

        $resource = $result->getResource();

        return $this->success(['resource' => [
            'title'   => base64_encode($resource['title']),
            'message' => base64_encode($resource['message']),
            'targets' => strval($request->input('targets')),
            'options' => base64_encode($resource['options']),
        ]]);
    }
}
