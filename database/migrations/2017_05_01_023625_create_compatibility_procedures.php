<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class CreateCompatibilityProcedures extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $sql = <<<SQL
CREATE OR REPLACE FUNCTION get_statically_compatible()
  RETURNS TABLE(component_id components.id%TYPE, compatible_component_id components.id%TYPE) AS $$
DECLARE
  component     components%ROWTYPE;
  compatible_id components.id%TYPE;
BEGIN
  FOR component IN SELECT *
                   FROM components LOOP
    CASE component.child_type
      WHEN 'chassis'
      THEN
        FOR compatible_id IN SELECT get_statically_compatible_for_chassis(component) LOOP
          RETURN NEXT (component.id, compatible_id);
        END LOOP;
    END CASE;
  END LOOP;
END;
$$ LANGUAGE plpgsql;

CREATE OR REPLACE FUNCTION get_statically_compatible_for_chassis(component chassis_components%ROWTYPE)
  RETURNS SETOF components.id%TYPE AS $$
DECLARE
  --
BEGIN
  -- motherboard
  RETURN QUERY
  SELECT components.id
  FROM components
    INNER JOIN motherboard_components
      ON components.child_id = motherboard_components.id
         AND components.child_type = 'motherboard'
  WHERE motherboard_components.audio_headers >= component.audio_headers
        AND motherboard_components.fan_headers >= component.fan_headers
        AND motherboard_components.usb2_headers >= component.usb2_headers
        AND motherboard_components.usb3_headers >= component.usb3_headers
        AND motherboard_components.form_factor_id IN
            (SELECT form_factor_id
             FROM chassis_components
               INNER JOIN chassis_component_form_factor
                 ON chassis_components.id = chassis_component_form_factor.chassis_component_id
            );

  -- power
  RETURN QUERY
  SELECT id
  FROM components
  WHERE child_type = 'power';
END;
$$ LANGUAGE plpgsql;
SQL;

        //DB::unprepared($sql);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $sql = <<<SQL
DROP FUNCTION IF EXISTS get_statically_compatible();
DROP FUNCTION IF EXISTS get_statically_compatible_for_chassis(chassis_components%ROWTYPE);
SQL;

        //DB::unprepared($sql);
    }
}
