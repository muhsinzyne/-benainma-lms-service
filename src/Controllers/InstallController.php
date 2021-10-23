<?php
namespace MuhsinZyne\BenainmaLmsService\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use MuhsinZyne\BenainmaLmsService\Repositories\InstallRepository;
use MuhsinZyne\BenainmaLmsService\Repositories\InstallRepository as ServiceRepository;
use MuhsinZyne\BenainmaLmsService\Requests\UserRequest;
use Illuminate\Support\Facades\Storage;

class InstallController extends Controller
{
    protected $repo;
    protected $request;
    protected $service_repo;

    public function __construct(
        InstallRepository $repo,
        Request $request,
        ServiceRepository $service_repo
    ) {
        $this->repo         = $repo;
        $this->request      = $request;
        $this->service_repo = $service_repo;
    }

    public function index()
    {
        $this->service_repo->checkInstallation();

        return view('lms::install.welcome');
    }

    public function user()
    {
        $ac = Storage::exists('.temp_app_installed') ? Storage::get('.temp_app_installed') : null;

        if (!$this->service_repo->checkDatabaseConnection() || !$ac) {
            abort(404);
        }

        return view('lms::install.user');
    }

    public function post_user(UserRequest $request)
    {
        try {
            $this->service_repo->install($request->all());
        } catch (\Exception $e) {
            return response()->json(['message' =>$e->getMessage()]);
        }

        $this->repo->install($request->all());

        return response()->json(['message' => __('lms::install.done_msg'), 'goto' => route('service.done')]);
    }
}
