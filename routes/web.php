<?php

use App\Http\Controllers\Auth\ValidateInvitationController;
use App\Http\Controllers\LocaleController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Projects\ProjectCommentController;
use App\Http\Controllers\Projects\ProjectController;
use App\Http\Controllers\Projects\ProjectMemberController;
use App\Http\Controllers\Projects\ProjectMessageController;
use App\Http\Controllers\Settings\SettingsController;
use App\Http\Controllers\Settings\SettingsInviteUserController;
use App\Http\Controllers\Settings\SettingsOfficeController;
use App\Http\Controllers\Settings\SettingsOrganizationController;
use App\Http\Controllers\Settings\SettingsRoleController;
use App\Http\Controllers\Settings\SettingsUserController;
use App\Http\Controllers\Users\UserAvatarController;
use App\Http\Controllers\Users\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('locale/{locale}', [LocaleController::class, 'update'])->name('locale.update');

Route::get('invitation/{code}', [ValidateInvitationController::class, 'show'])->name('invitation.validate.show');
Route::post('invitation/{code}', [ValidateInvitationController::class, 'update'])->name('invitation.validate.update');

Route::get('dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth', 'verified')->group(function (): void {
    Route::get('search', [SearchController::class, 'index'])->name('search.index');

    Route::get('profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // users
    Route::get('users/{user}', [UserController::class, 'show'])->name('user.show');

    Route::middleware(['user'])->group(function (): void {
        Route::get('users/{user}/edit', [UserController::class, 'edit'])->name('user.edit');
        Route::put('users/{user}', [UserController::class, 'update'])->name('user.update');
        Route::put('users/{user}/avatar', [UserAvatarController::class, 'update'])->name('user.avatar.update');
    });

    // projects
    Route::get('projects', [ProjectController::class, 'index'])->name('project.index');
    Route::get('projects/create', [ProjectController::class, 'create'])->name('project.create');
    Route::post('projects', [ProjectController::class, 'store'])->name('project.store');

    Route::middleware(['project'])->group(function (): void {
        Route::get('projects/{project}', [ProjectController::class, 'show'])->name('project.show');
        Route::get('projects/{project}/edit', [ProjectController::class, 'edit'])->name('project.edit');
        Route::put('projects/{project}', [ProjectController::class, 'update'])->name('project.update');
        Route::delete('projects/{project}', [ProjectController::class, 'destroy'])->name('project.destroy');

        // members
        Route::get('projects/{project}/members', [ProjectMemberController::class, 'index'])->name('project.member.index');
        Route::get('projects/{project}/members/{user}/delete', [ProjectMemberController::class, 'delete'])->name('project.member.delete');

        Route::get('projects/{project}/users', [ProjectMemberController::class, 'index'])->name('members.user.index');
        Route::post('projects/{project}/members/{member}', [ProjectMemberController::class, 'store'])->name('members.user.store');
        Route::delete('projects/{project}/members/{user}', [ProjectMemberController::class, 'destroy'])->name('project.member.destroy');

        // messages
        Route::get('projects/{project}/messages', [ProjectMessageController::class, 'index'])->name('project.message.index');
        Route::get('projects/{project}/messages/create', [ProjectMessageController::class, 'create'])->name('project.message.create');
        Route::post('projects/{project}/messages', [ProjectMessageController::class, 'store'])->name('project.message.store');

        Route::middleware(['message'])->group(function (): void {
            Route::get('projects/{project}/messages/{message}', [ProjectMessageController::class, 'show'])->name('project.message.show');
            Route::get('projects/{project}/messages/{message}/delete', [ProjectMessageController::class, 'delete'])->name('project.message.delete');
            Route::get('projects/{project}/messages/{message}/edit', [ProjectMessageController::class, 'edit'])->name('project.message.edit');
            Route::put('projects/{project}/messages/{message}', [ProjectMessageController::class, 'update'])->name('project.message.update');
            Route::delete('projects/{project}/messages/{message}', [ProjectMessageController::class, 'destroy'])->name('project.message.destroy');

            Route::middleware(['comment'])->group(function (): void {
                Route::get('projects/{project}/messages/{message}/comments/{comment}/edit', [ProjectCommentController::class, 'edit'])->name('project.message.comment.edit');
                Route::put('projects/{project}/messages/{message}/comments/{comment}', [ProjectCommentController::class, 'update'])->name('project.message.comment.update');
                Route::get('projects/{project}/messages/{message}/comments/{comment}/delete', [ProjectCommentController::class, 'delete'])->name('project.message.comment.delete');
                Route::delete('projects/{project}/messages/{message}/comments/{comment}', [ProjectCommentController::class, 'destroy'])->name('project.message.comment.destroy');
            });
        });
    });

    // tasklists
    Route::get('{project}/taskLists', [ProjectTaskListController::class, 'index'])->name('tasks.index');

    // settings
    Route::middleware(['administrator'])->group(function (): void {
        Route::get('settings', [SettingsController::class, 'index'])->name('settings.index');

        // user management
        Route::get('settings/users', [SettingsUserController::class, 'index'])->name('settings.user.index');
        Route::get('settings/users/invite', [SettingsUserController::class, 'create'])->name('settings.user.create');
        Route::post('settings/users/invite', [SettingsUserController::class, 'store'])->name('settings.user.store');
        Route::get('settings/users/{user}/edit', [SettingsUserController::class, 'edit'])->name('settings.user.edit');
        Route::put('settings/users/{user}', [SettingsUserController::class, 'update'])->name('settings.user.update');
        Route::post('settings/users/{user}/send', [SettingsInviteUserController::class, 'store'])->name('settings.user.invite.store');
        Route::get('settings/users/{user}/delete', [SettingsUserController::class, 'delete'])->name('settings.user.delete');
        Route::delete('settings/users/{user}', [SettingsUserController::class, 'destroy'])->name('settings.user.destroy');

        // organization management
        Route::get('settings/organization', [SettingsOrganizationController::class, 'index'])->name('settings.organization.index');
        Route::post('settings/organization', [SettingsOrganizationController::class, 'store'])->name('settings.organization.store');

        // office management
        Route::get('settings/offices', [SettingsOfficeController::class, 'index'])->name('settings.office.index');
        Route::get('settings/offices/create', [SettingsOfficeController::class, 'create'])->name('settings.office.create');
        Route::post('settings/offices', [SettingsOfficeController::class, 'store'])->name('settings.office.store');
        Route::get('settings/offices/{office}/edit', [SettingsOfficeController::class, 'edit'])->name('settings.office.edit');
        Route::put('settings/offices/{office}', [SettingsOfficeController::class, 'update'])->name('settings.office.update');
        Route::get('settings/offices/{office}/delete', [SettingsOfficeController::class, 'delete'])->name('settings.office.delete');
        Route::delete('settings/offices/{office}', [SettingsOfficeController::class, 'destroy'])->name('settings.office.destroy');

        // role
        Route::get('settings/roles', [SettingsRoleController::class, 'index'])->name('settings.role.index');
        Route::get('settings/roles/create', [SettingsRoleController::class, 'create'])->name('settings.role.create');
        Route::post('settings/roles', [SettingsRoleController::class, 'store'])->name('settings.role.store');
        Route::get('settings/roles/{role}/edit', [SettingsRoleController::class, 'edit'])->name('settings.role.edit');
        Route::put('settings/roles/{role}', [SettingsRoleController::class, 'update'])->name('settings.role.update');
        Route::get('settings/roles/{role}/delete', [SettingsRoleController::class, 'delete'])->name('settings.role.delete');
        Route::delete('settings/roles/{role}', [SettingsRoleController::class, 'destroy'])->name('settings.role.destroy');

        // team type management
        Route::get('settings/teamTypes', [PersonalizeTeamTypeController::class, 'index'])->name('settings.personalize.team_type.index');
        Route::get('settings/teamTypes/create', [PersonalizeTeamTypeController::class, 'create'])->name('settings.personalize.team_type.create');
        Route::post('settings/teamTypes', [PersonalizeTeamTypeController::class, 'store'])->name('settings.personalize.team_type.store');
        Route::get('settings/teamTypes/{teamType}/edit', [PersonalizeTeamTypeController::class, 'edit'])->name('settings.personalize.team_type.edit');
        Route::put('settings/teamTypes/{teamType}', [PersonalizeTeamTypeController::class, 'update'])->name('settings.personalize.team_type.update');
        Route::delete('settings/teamTypes/{teamType}', [PersonalizeTeamTypeController::class, 'destroy'])->name('settings.personalize.team_type.destroy');

        Route::middleware(['account_manager'])->group(function (): void {
            Route::get('settings/delete', [SettingsOrganizationController::class, 'delete'])->name('settings.organization.delete');
            Route::delete('settings', [SettingsOrganizationController::class, 'destroy'])->name('settings.organization.destroy');

            Route::get('settings/upgrade', [PersonalizeUpgradeController::class, 'index'])->name('settings.personalize.upgrade.index');
            Route::put('settings/upgrade', [PersonalizeUpgradeController::class, 'update'])->name('settings.personalize.upgrade.update');
        });
    });
});

require __DIR__ . '/auth.php';
