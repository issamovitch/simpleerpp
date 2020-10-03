<?php

use Illuminate\Support\Facades\Route;

Route::group(["namespace" => "App\Http\Controllers"], function(){

    Route::get("/", "BaseController@index")->name('index');
    // Auth
    Route::get('login', 'BaseController@index')->name('login');
    Route::post('login', 'Auth\LoginController@login')->name('login');
    Route::get('logout', 'Auth\LoginController@logout')->name('logout');
    Route::get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('password.request');
    Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
    Route::get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset');
    Route::post('password/reset', 'Auth\ResetPasswordController@reset')->name('password.update');

    Route::group(["middleware" => "auth"], function() {

        Route::get("dashboard", "Dashboard@index")->name('dashboard');

        // Users
        Route::group(["as" => "users.","prefix" => "users"], function () {
            Route::get('index', "Users@index")->name("index");
            Route::get('add', "Users@add")->name("add");
            Route::post('save', "Users@save")->name("save");
            Route::get('edit/{id?}', "Users@edit")->name("edit");
            Route::post('update', "Users@update")->name("update");
            Route::get('delete/{id?}', "Users@delete")->name("delete");
            Route::get('view/{id?}', "Users@view")->name("view");
            Route::post('users_display', "Users@users_display")->name("users_display");
            Route::post('designations_save', "Users@designations_save")->name("designations_save");
            Route::post('departments_save', "Users@departments_save")->name("departments_save");
        });

        // Clients
        Route::group(["as" => "clients.","prefix" => "clients"], function () {
            Route::get('index', "Clients@index")->name("index");
            Route::get('add', "Clients@add")->name("add");
            Route::post('sectors_save', "Clients@sectors_save")->name("sectors_save");
            Route::post('save_client_group', "Clients@save_client_group")->name("save_client_group");
            Route::post('save', "Clients@save")->name("save");
            Route::get('edit/{id?}', "Clients@edit")->name("edit");
            Route::post('update', "Clients@update")->name("update");
            Route::get('delete/{id?}', "Clients@delete")->name("delete");
            Route::get('view/{id?}', "Clients@view")->name("view");
            Route::get('reference_unique', "Clients@reference_unique")->name("reference_unique");
        });

        // Mailbox
        Route::group(["as" => "mailbox.","prefix" => "mailbox"], function () {
            // Labels
            Route::get('get_labels', "Mailbox@get_labels")->name("get_labels");
            Route::post('save_label', "Mailbox@save_label")->name("save_label");
            Route::get('delete_label/{id?}', "Mailbox@delete_label")->name("delete_label");
            // Compose
            Route::get('compose', "Mailbox@compose")->name("compose");
            Route::post('save_message', "Mailbox@save_message")->name("save_message");
            // Inbox
            Route::get('inbox', "Mailbox@inbox")->name("inbox");
            // Sent
            Route::get('sent', "Mailbox@sent")->name("sent");
            // Draft
            Route::get('draft', "Mailbox@draft")->name("draft");
            Route::get('send_draft/{id?}', "Mailbox@send_draft")->name("send_draft");
            // Trash
            Route::get('trash', "Mailbox@trash")->name("trash");
            // Favorite
            Route::get('favorite', "Mailbox@favorite")->name("favorite");
            // Operations
            Route::get('unfavorite/{id?}', "Mailbox@unfavorite")->name("unfavorite");
            Route::get('dofavorite/{id?}', "Mailbox@dofavorite")->name("dofavorite");
            Route::post('delete', "Mailbox@delete")->name("delete");
            Route::get('delete_message/{id?}', "Mailbox@delete_message")->name("delete_message");
            Route::get('message/{id?}', "Mailbox@message")->name("message");
            Route::post('search', "Mailbox@search")->name("search");
        });

        // Settings
        Route::group(["prefix" => "settings", "as" => "settings."], function (){
            // General Settings
            Route::get("/", "Settings@index")->name("index");
            Route::get("general_settings", "Settings@general_settings")->name("general_settings");
            Route::post("general_settings_save", "Settings@general_settings_save")->name("general_settings_save");
            // SMTP
            Route::get('smtp_settings', "Settings@smtp_settings")->name("smtp_settings");
            Route::post('smtp_settings_save', "Settings@smtp_settings_save")->name("smtp_settings_save");
            // Roles & permissions
            Route::get("roles", "Settings@roles")->name("roles");
            Route::post("roles_save", "Settings@roles_save")->name("roles_save");
            Route::get("roles_delete/{id?}", "Settings@roles_delete")->name("roles_delete");
            // Designations
            Route::get('designations', "Settings@designations")->name("designations");
            Route::post('designations_save', "Settings@designations_save")->name("designations_save");
            Route::post('designations_update', "Settings@designations_update")->name("designations_update");
            Route::get('designations_delete/{id?}', "Settings@designations_delete")->name("designations_delete");
            // Departments
            Route::get('departments', "Settings@departments")->name("departments");
            Route::post('departments_save', "Settings@departments_save")->name("departments_save");
            Route::post('departments_update', "Settings@departments_update")->name("departments_update");
            Route::get('departments_delete/{id?}', "Settings@departments_delete")->name("departments_delete");
            // Sectors
            Route::get('sectors', "Settings@sectors")->name("sectors");
            Route::post('sectors_save', "Settings@sectors_save")->name("sectors_save");
            Route::post('sectors_update', "Settings@sectors_update")->name("sectors_update");
            Route::get('sectors_delete/{id?}', "Settings@sectors_delete")->name("sectors_delete");
            // Client Groups
            Route::get('client_groups', "Settings@client_groups")->name("client_groups");
            Route::post('client_groups_save', "Settings@client_groups_save")->name("client_groups_save");
            Route::post('client_groups_update', "Settings@client_groups_update")->name("client_groups_update");
            Route::get('client_groups_delete/{id?}', "Settings@client_groups_delete")->name("client_groups_delete");
        });

    });

});

