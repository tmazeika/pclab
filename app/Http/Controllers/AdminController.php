<?php

namespace PCForge\Http\Controllers;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PCForge\Events\NewComponentAdded;

class AdminController extends Controller
{
    const TABLE_MODEL_DICT = [
        'chassis_components'            => 'PCForge\Models\ChassisComponent',
        'chassis_component_form_factor' => 'PCForge\Models\ChassisComponentFormFactor',
        'chassis_components_radiators'  => 'PCForge\Models\ChassisComponentsRadiator',
        'compatibilities'               => 'PCForge\Models\Compatibility',
        'components'                    => 'PCForge\Models\Component',
        'cooling_components'            => 'PCForge\Models\CoolingComponent',
        'cooling_component_socket'      => 'PCForge\Models\CoolingComponentSocket',
        'form_factors'                  => 'PCForge\Models\FormFactor',
        'graphics_components'           => 'PCForge\Models\GraphicsComponent',
        'memory_components'             => 'PCForge\Models\MemoryComponent',
        'motherboard_components'        => 'PCForge\Models\MotherboardComponent',
        'power_components'              => 'PCForge\Models\PowerComponent',
        'processor_components'          => 'PCForge\Models\ProcessorComponent',
        'sockets'                       => 'PCForge\Models\Socket',
        'storage_components'            => 'PCForge\Models\StorageComponent',
        'storage_widths'                => 'PCForge\Models\StorageWidth',
    ];

    public function index()
    {
        return view('admin.index');
    }

    public function showCreate(string $table)
    {
        return view('admin.create', compact('table'));
    }

    public function showUpdate(string $table, int $id)
    {
        $item = DB::table($table)->find($id);

        return view('admin.update', compact('table', 'id', 'item'));
    }

    public function create(Request $request, string $table)
    {
        $model = $this->getModelForTable($table);

        $this->validateModelInput($model, $request->all(), 'create');
        $model->fill($request->all());
        $model->save();

        return redirect('admin');
    }

    public function update(Request $request, string $table, $id)
    {
        $model = ($this->getModelForTable($table))::find($id);

        $changes = $this->isolateChanges($model->getAttributes(), $request->all());
        $this->validateModelInput($model, $changes, 'update');
        $model->fill($changes);
        $model->save();

        return redirect('admin');
    }

    public function delete(string $table, int $id)
    {
        try {
            DB::table($table)->where('id', $id)->delete();
        }
        catch (QueryException $e) {
            abort(400, $e->getMessage());
        }

        return redirect()->back();
    }

    public function updateCompatibilities()
    {
        event(new NewComponentAdded);

        return redirect()->back();
    }

    private function isolateChanges(array $old, array $new): array
    {
        // contains new keys with their values, as well as keys already existing in the old array with new values
        $result = [];

        foreach ($old as $key => $oldValue) {
            if (isset($new[$key])) {
                $newValue = $new[$key];

                if ($newValue != $oldValue) {
                    $result[$key] = $newValue;
                }
            }
        }

        foreach ($new as $key => $newValue) {
            if (!isset($old[$key])) {
                $result[$key] = $newValue;
            }
        }

        return $result;
    }

    private function getModelForTable(string $table): Model
    {
        if (!array_key_exists($table, self::TABLE_MODEL_DICT)) {
            abort(400, 'Invalid table');
        }

        $modelName = self::TABLE_MODEL_DICT[$table];

        return new $modelName;
    }

    private function validateModelInput($model, array $input, string $op)
    {
        if (!$model->validate($input, $op)) {
            abort(400, $model->errors());
        }
    }
}
