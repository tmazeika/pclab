<?php

namespace PCForge\Http\Controllers;

use Illuminate\Http\Request;
use PCForge\Events\ComponentModified;

class AdminController extends Controller
{
    public function index()
    {
        return view('admin.index');
    }

    public function showCreate(string $model)
    {
        return view('admin.create', compact('model'));
    }

    public function showUpdate(string $model, int $id)
    {
        $item = $model::find($id);

        return view('admin.update', compact('model', 'item'));
    }

    public function create(Request $request, string $model)
    {
        $this->validateModelInput($model, $request->all(), 'CREATE');
        $model->fill($request->all());
        $model->save();

        return redirect('admin');
    }

    private function validateModelInput($model, array $input, string $op)
    {
        if (!$model::validate($input, $op)) {
            abort(400, $model->errors());
        }
    }

    public function update(Request $request, string $modelFqn, $id)
    {
        $model = $modelFqn::lockForUpdate()->find($id);

        $changes = $this->isolateChanges($model->getAttributes(), $request->all());
        $this->validateModelInput($model, $changes, 'UPDATE');
        $model->fill($changes);
        $model->save();

        return redirect('admin');
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

    public function delete(string $model, int $id)
    {
        $model::where('id', $id)->delete();

        return redirect()->back();
    }

    public function updateCompatibilities()
    {
        event(new ComponentModified);

        return redirect()->back();
    }
}
