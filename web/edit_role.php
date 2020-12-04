<?php
namespace MRBS;

use MRBS\Form\Element;
use MRBS\Form\ElementFieldset;
use MRBS\Form\ElementInputRadio;
use MRBS\Form\ElementInputSubmit;
use MRBS\Form\ElementP;
use MRBS\Form\FieldDiv;
use MRBS\Form\FieldInputRadioGroup;
use MRBS\Form\FieldInputText;
use MRBS\Form\FieldSelect;
use MRBS\Form\Form;

require "defaultincludes.inc";


function generate_add_role_form($error=null, $name=null)
{
  $form = new Form();
  $form->addHiddenInput('action', 'add')
       ->setAttributes(array('action' => multisite('edit_role_handler.php'),
                             'class'  => 'standard',
                             'method' => 'post'));

  // Name field
  $fieldset = new ElementFieldset();

  if (isset($error))
  {
    $field = new FieldDiv();
    $p = new ElementP();
    $p->setText(get_vocab($error, $name))
      ->setAttribute('class', 'error');
    $field->addControlElement($p);
    $fieldset->addElement($field);
  }

  $field = new FieldInputText();
  // Set a pattern as well as required to prevent a string of whitespace
  $field->setLabel(get_vocab('role_name'))
        ->setControlAttributes(array('name'     => 'name',
                                     'required' => true,
                                     'pattern'  => REGEX_TEXT_POS));
  if (null !== ($maxlength = maxlength('role.name')))
  {
    $field->setControlAttribute('maxlength', $maxlength);
  }
  $fieldset->addElement($field);
  $form->addElement($fieldset);

  // Submit button
  $fieldset = new ElementFieldset();
  $field = new FieldDiv();
  $element = new ElementInputSubmit();
  $element->setAttributes(array(
      'name'  => 'button_save',
      'value' => get_vocab('add_role'))
    );
  $field->addControl($element);
  $fieldset->addElement($field);
  $form->addElement($fieldset);

  $form->render();
}


function generate_add_role_area_button(Role $role)
{
  $form = new Form();
  $form->addHiddenInputs(array('action' => 'add_role_area',
                               'role_id' => $role->id))
       ->setAttributes(array('action' => multisite(this_page()),
                             'class'  => 'standard',
                             'method' => 'post'));

  // Submit button
  $fieldset = new ElementFieldset();
  $field = new FieldDiv();
  $element = new ElementInputSubmit();
  $element->setAttributes(array(
    'name'  => 'button_save',
    'value' => get_vocab('add_role_area'))
  );
  $field->addControl($element);
  $fieldset->addElement($field);
  $form->addElement($fieldset);

  $form->render();
}


function generate_add_role_room_button(Role $role)
{
  $form = new Form();
  $form->addHiddenInputs(array('action' => 'add_role_room',
                               'role_id' => $role->id))
    ->setAttributes(array('action' => multisite(this_page()),
                         'class'  => 'standard',
                         'method' => 'post'));

  // Submit button
  $fieldset = new ElementFieldset();
  $field = new FieldDiv();
  $element = new ElementInputSubmit();
  $element->setAttributes(array(
      'name'  => 'button_save',
      'value' => get_vocab('add_role_room'))
    );
  $field->addControl($element);
  $fieldset->addElement($field);
  $form->addElement($fieldset);

  $form->render();
}


function generate_add_role_area_form(Role $role, $error, $area_id)
{
  $form = new Form();
  $form->addHiddenInputs(array('action' => 'add_role_area',
                               'role_id' => $role->id))
       ->setAttributes(array('action' => multisite('edit_role_handler.php'),
                             'class'  => 'standard',
                             'method' => 'post'));

  $fieldset = new ElementFieldset();

  if (isset($error))
  {
    $area = Area::getById($area_id);
    $field = new FieldDiv();
    $p = new ElementP();
    $p->setText(get_vocab($error, $area->area_name))
      ->setAttribute('class', 'error');
    $field->addControlElement($p);
    $fieldset->addElement($field);
  }

  // The area select
  $areas = new Areas();
  $field = new FieldSelect();
  $field->setLabel(get_vocab('area'))
        ->setControlAttributes(array('name' => 'area_id'))
        ->addSelectOptions($areas->getNames(true), null, true);
  $fieldset->addElement($field);

  // Permission
  $field = new FieldInputRadioGroup();
  $field->setLabel(get_vocab('permission'))
        ->addRadioOptions(AreaPermission::getPermissionOptions(),
                          'permission',
                          AreaPermission::$permission_default,
                          true);
  $fieldset->addElement($field);

  // State
  $field = new FieldInputRadioGroup();
  $field->setLabel(get_vocab('state'))
        ->addRadioOptions(AreaPermission::getStateOptions(),
                          'state',
                          AreaPermission::$state_default,
                          true);
  $fieldset->addElement($field);

  $form->addElement($fieldset);

  // Submit button
  $fieldset = new ElementFieldset();
  $field = new FieldDiv();
  $element = new ElementInputSubmit();
  $element->setAttributes(array(
      'name'  => 'button_save',
      'value' => get_vocab('add_role_area'))
    );
  $field->addControl($element);
  $fieldset->addElement($field);
  $form->addElement($fieldset);

  $form->render();
}


function generate_add_role_room_form(Role $role, $error, $room_id)
{
  $form = new Form();
  $form->addHiddenInputs(array('action' => 'add_role_room',
                               'role_id' => $role->id))
       ->setAttributes(array('action' => multisite('edit_role_handler.php'),
                             'class'  => 'standard',
                             'method' => 'post'));

  $fieldset = new ElementFieldset();

  if (isset($error))
  {
    $room = Room::getById($room_id);
    $field = new FieldDiv();
    $p = new ElementP();
    $p->setText(get_vocab($error, $room->area_name, $room->room_name))
      ->setAttribute('class', 'error');
    $field->addControlElement($p);
    $fieldset->addElement($field);
  }

  // The room select
  $rooms = new Rooms();
  $field = new FieldSelect();
  $field->setLabel(get_vocab('room'))
        ->setControlAttributes(array('name' => 'room_id'))
        ->addSelectOptions($rooms->getGroupedNames(true), null, true);
  $fieldset->addElement($field);

  // Permission
  $field = new FieldInputRadioGroup();
  $field->setLabel(get_vocab('permission'))
        ->addRadioOptions(AreaPermission::getPermissionOptions(),
                          'permission',
                          AreaPermission::$permission_default,
                          true);
  $fieldset->addElement($field);

  // State
  $field = new FieldInputRadioGroup();
  $field->setLabel(get_vocab('state'))
        ->addRadioOptions(AreaPermission::getStateOptions(),
                          'state',
                          AreaPermission::$state_default,
                          true);
  $fieldset->addElement($field);

  $form->addElement($fieldset);

  // Submit button
  $fieldset = new ElementFieldset();
  $field = new FieldDiv();
  $element = new ElementInputSubmit();
  $element->setAttributes(array(
      'name'  => 'button_save',
      'value' => get_vocab('add_role_room'))
    );
  $field->addControl($element);
  $fieldset->addElement($field);
  $form->addElement($fieldset);

  $form->render();
}


function generate_delete_role_button(Role $role)
{
  $form = new Form();
  $form->setAttributes(array('action' => multisite('edit_role_handler.php'),
                             'method' => 'post'));

  // Hidden inputs
  $form->addHiddenInputs(array(
      'action' => 'delete_role',
      'role_id' => $role->id
    ));

  // Submit button
  $button = new ElementInputSubmit();
  $message = get_vocab("confirm_del_role", $role->name);
  $button->setAttributes(array(
      'name'    => 'button_save',
      'value'   => get_vocab('delete'),
      'onclick' => "return confirm('" . escape_js($message) . "');"
    ));

  $form->addElement($button);
  $form->render();
}


function generate_roles_table()
{
  $roles = new Roles();

  echo "<table class=\"admin_table display\" id=\"roles\">\n";

  echo "<thead>\n";
  echo "<tr>";
  echo "<th></th>";
  echo "<th>" . htmlspecialchars(get_vocab('role')) . "</th>";
  echo "</tr>\n";
  echo "</thead>\n";

  echo "<tbody>\n";

  foreach ($roles as $role)
  {
    echo "<tr>";
    echo "<td>";
    generate_delete_role_button($role);
    echo "</td>";

    echo "<td>";
    $href = multisite(this_page() . '?role_id=' . $role->id);
    echo '<a href="' . htmlspecialchars($href). '">' . htmlspecialchars($role->name) . '</a>';
    echo "</td>";
    echo "</tr>\n";
  }

  echo "</tbody>\n";
  echo "</table>\n";
}


function generate_empty_row(Area $area)
{
  $tr = new Element('tr');
  // The delete button column
  $td = new Element('td');
  $tr->addElement($td);
  // The area name
  $td = new Element('td');
  $td->setText($area->area_name);
  $tr->addElement($td)
     ->setAttribute('class', 'area');
  // The empty cells
  for ($i=0; $i<6; $i++)
  {
    $td = new Element('td');
    $tr->addElement($td);
  }

  return $tr;
}


function generate_delete_permission_button(LocationPermission $permission)
{
  $form = new Form();
  $form->setAttributes(array('action' => multisite('edit_role_handler.php'),
                             'method' => 'post'));

  // Hidden inputs
  $form->addHiddenInputs(array(
      'role_id' => $permission->role_id,
    ));

  if (isset($permission->area_id))
  {
    $form->addHiddenInput('area_id', $permission->area_id);
  }

  if (isset($permission->room_id))
  {
    $form->addHiddenInput('room_id', $permission->room_id);
  }

  // Submit button
  $button = new ElementInputSubmit();
  if (isset($permission->room_name))
  {
    $message = get_vocab("confirm_del_permission_room", $permission->room_name);
  }
  else
  {
    $message = get_vocab("confirm_del_permission_area", $permission->area_name);
  }
  $button->setAttributes(array(
      'name'    => 'button_delete',
      'value'   => get_vocab('delete'),
      'onclick' => "return confirm('" . escape_js($message) . "');"
    ));

  $form->addElement($button);
  return $form;
}
$vocab["confirm_del_permission_area"] = "Are you sure you want to delete the permissions for area '%s'?";

function generate_row(LocationPermission $permission, array $permission_options, array $state_options, $type='area')
{
  if ($type == 'area')
  {
    $text = $permission->area_name;
    $name_permission = $type. '[' . $permission->area_id . '][permission]';
    $name_state      = $type. '[' . $permission->area_id . '][state]';
  }
  else
  {
    $text = $permission->room_name;
    $name_permission = $type. '[' . $permission->room_id . '][permission]';
    $name_state      = $type. '[' . $permission->room_id . '][state]';
  }

  $tr = new Element('tr');
  $tr->setAttribute('class', $type);
  // Delete button
  $td = new Element('td');
  $td->addElement(generate_delete_permission_button($permission));
  $tr->addElement($td);
  // Area/room name
  $td = new Element('td');
  $td->setText($text);
  $tr->addElement($td);
  // Permission
  foreach ($permission_options as $key => $value)
  {
    $td = new Element('td');
    $radio = new ElementInputRadio();
    $radio->setAttributes(array(
        'name' => $name_permission,
        'value' => $key
      ));
    if ($permission->permission === $key)
    {
      $radio->setAttribute('checked');
    }
    $td->addElement($radio);
    $tr->addElement($td);
  }
  // State
  foreach ($state_options as $key => $value)
  {
    $td = new Element('td');
    $radio = new ElementInputRadio();
    $radio->setAttributes(array(
        'name' => $name_state,
        'value' => $key
      ));
    if ($permission->state === $key)
    {
      $radio->setAttribute('checked');
    }
    $td->addElement($radio);
    $tr->addElement($td);
  }

  return $tr;
}


function generate_area_roles_table(Role $role)
{
  $permission_options = AreaPermission::getPermissionOptions();
  $state_options = AreaPermission::getStateOptions();

  $form = new Form();
  $form->setAttributes(array(
      'class' => 'roles_table_form',
      'action' => multisite('edit_role_handler.php'),
      'method' => 'post'
    ));
  $form->addHiddenInputs(array(
      'role_id' => $role->id,
      'action'  => 'edit_role_area_room'
    ));
  $fieldset = new ElementFieldset();

  $table = new Element('table');
  $table->setAttribute('class', 'roles_table');
  $thead = new Element('thead');
  $tr = new Element('tr');
  $tr->setAttribute('class', 'area');
  // Delete buttons
  $th = new Element('th');
  $tr->addElement($th);
  // Area name
  $th = new Element('th');
  $th->setText(get_vocab('area'));
  $tr->addElement($th);
  // Permission
  $th = new Element('th');
  $th->setAttribute('colspan', count($permission_options))
     ->setText(get_vocab('permission'));
  $tr->addElement($th);
  // State
  $th = new Element('th');
  $th->setAttribute('colspan', count($state_options))
    ->setText(get_vocab('state'));
  $tr->addElement($th);
  $thead->addElement($tr);

  $tr = new Element('tr');
  // Delete buttons
  $th = new Element('th');
  $tr->addElement($th);
  // Room name
  $tr->setAttribute('class', 'room');
  $th = new Element('th');
  $th->setText(get_vocab('room'));
  $tr->addElement($th);
  // Permission options
  foreach ($permission_options as $key => $value)
  {
    $th = new Element('th');
    $th->setText($value);
    $tr->addElement($th);
  }
  // State options
  foreach ($state_options as $key => $value)
  {
    $th = new Element('th');
    $th->setText($value);
    $tr->addElement($th);
  }
  $thead->addElement($tr);
  $table->addElement($thead);

  $tbody = new Element('tbody');

  $areas = new Areas();

  foreach ($areas as $area)
  {
    $area_permission = AreaPermission::getByRoleArea($role->id, $area->id);
    $room_permissions = new RoomPermissions($role, $area->id);

    if (isset($area_permission))
    {
      $tbody->addElement(generate_row($area_permission,
                         $permission_options,
                         $state_options,
                         'area'));
    }
    elseif (count($room_permissions) > 0)
    {
      // We need a "header" row for the row permissions
      $tbody->addElement(generate_empty_row($area));
    }

    foreach ($room_permissions as $room_permission)
    {
      $tbody->addElement(generate_row($room_permission,
                                      $permission_options,
                                      $state_options,
                                      'room'));
    }
  }

  $table->addElement($tbody);
  $fieldset->addElement($table);
  $form->addElement($fieldset);

  // Submit buttons
  $fieldset = new ElementFieldset();
  $fieldset->setAttribute('class', 'buttons');
  // The Save button needs to be the first in the HTML source in
  // order to make it the default.  Use CSS to change the display order.
  $button = new ElementInputSubmit();
  $button->setAttributes(array(
      'name' => 'button_save',
      'value' => get_vocab('save')
    ));
  $fieldset->addElement($button);

  $button = new ElementInputSubmit();
  $button->setAttributes(array(
      'name' => 'button_back',
      'value' => get_vocab('back')
    ));
  $fieldset->addElement($button);
  $form->addElement($fieldset);

  $form->render();;
}


// Check the user is authorised for this page
checkAuthorised(this_page());

$context = array(
    'view'      => $view,
    'view_all'  => $view_all,
    'year'      => $year,
    'month'     => $month,
    'day'       => $day,
    'area'      => isset($area) ? $area : null,
    'room'      => isset($room) ? $room : null
  );

$action = get_form_var('action', 'string');
$error = get_form_var('error', 'string');
$area_id = get_form_var('area_id', 'int');
$room_id = get_form_var('room_id', 'int');
$role_id = get_form_var('role_id', 'int');
$name = get_form_var('name', 'string');

print_header($context);

if (isset($role_id))
{
  $role = Role::getById($role_id);
}

if (isset($role))
{
  echo "<h2>" . htmlspecialchars(get_vocab('role_heading', $role->name)) . "</h2>";
  if (isset($action))
  {
    switch($action)
    {
      case 'add_role_area':
        generate_add_role_area_form($role, $error, $area_id);
        break;
      case 'add_role_room':
        generate_add_role_room_form($role, $error, $room_id);
        break;
      default:
        throw new \Exception("Unknown action'$action'");
        break;
    }
  }
  else
  {
    generate_add_role_area_button($role);
    generate_add_role_room_button($role);
    generate_area_roles_table($role);
  }
}
else
{
  echo "<h2>" . htmlspecialchars(get_vocab('roles')) . "</h2>";
  generate_add_role_form($error, $name);
  generate_roles_table();
}

print_footer();
