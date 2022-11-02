<?php

//use Socialite;

use App\Cfg;
use App\User;
use App\Pref;

use App\News;

\View::composer(['admin.*'], function ($view) {
  // $Gcfg = Cfg::find(1);
  // $G['pref'] = ['*'=>'全て']+Pref::orderBy('id','asc')->lists('name','slug')->toArray();
  // $G['pref'] = Pref::orderBy('id','asc')->lists('name','slug')->toArray();
  // $view->with(compact('G','Gcfg'));
});

\View::composer(['front.*'], function ($view) {
  $default_period = 'second';
  $view->with(compact('default_period'));
  //	 $Gcfg = Cfg::find(1);
  //	 $G['pref'] = ['*'=>'全て']+Pref::orderBy('id','asc')->lists('name','slug')->toArray();
  //	 $G['pref'] = Pref::orderBy('id','asc')->lists('name','slug')->toArray();
  //	 $view->with(compact('G','Gcfg'));
});

\View::composer(['team.*'], function ($view) {
  $Groute['routeName'] = Route::currentRouteName();
  if (preg_match('/team\.account/', Route::currentRouteName())) {
    $tab_menu[6] = 'on';
  } elseif (preg_match('/team\.top/', Route::currentRouteName())) {
    $tab_menu[1] = 'on';
  } elseif (preg_match('/team\.match/', Route::currentRouteName())) {
    $tab_menu[1] = 'on';
  } elseif (preg_match('/team\.starter/', Route::currentRouteName())) {
    $tab_menu[1] = 'on';
  } elseif (preg_match('/team\.news/', Route::currentRouteName())) {
    $tab_menu[1] = 'on';
  } elseif (preg_match('/team\.info/', Route::currentRouteName())) {
    $tab_menu[2] = 'on';
  } elseif (preg_match('/team\.formation/', Route::currentRouteName())) {
    $tab_menu[3] = 'on';
  } elseif (preg_match('/team\.player/', Route::currentRouteName())) {
    $tab_menu[4] = 'on';
  } elseif (preg_match('/team\.league/', Route::currentRouteName())) {
    $tab_menu[5] = 'on';
  }
  $view->with(compact('Groute', 'tab_menu'));
});

Route::get('/hash/{pass}', function ($pass) {
  var_dump(password_verify('aaa', '$2y$10$K0DmAkxgGyTVmwgODBVJjOz0hmARiAHUPLyLdmRUc54Vk7rkA9w9y'));
  dd(password_hash($pass, PASSWORD_DEFAULT));
});

// Route::get('/', function () {
//   return \Redirect::to('/login');
//     // return view('welcome');
// });

// http://ffa.tkss.xyz/player_organization_fix
Route::get('/player_organization_fix', function () {
  $orgs = \App\Organizations::all();
  foreach ($orgs as $org) {
    $query = sprintf("update players set organizations_id=%d where team_id in (select id as team_id from teams where organizations_id = %d)", $org->id, $org->id);
    // print($query);
    \DB::update($query);
  }
  return "<br>finished";
});

// Route::get('api/genBranch',['uses'=>'ApiController@genBranch','as'=>'api.gen.branch']);

// Route::get('/', ['uses' => 'FrontController@index', 'as' => 'front.index']);
// Route::get('contact', ['uses' => 'FrontController@contact', 'as' => 'front.contact']);
// Route::post('contact', ['uses' => 'FrontController@contact_post', 'as' => 'front.contact.post']);
// Route::get('thanks', ['uses' => 'FrontController@thanks', 'as' => 'front.thanks']);
// Route::get('about', ['uses' => 'FrontController@about', 'as' => 'front.about']);
// Route::get('live', ['uses' => 'FrontController@live', 'as' => 'front.live']);
// Route::get('abstract', ['uses' => 'FrontController@abst', 'as' => 'front.abstract']);
// Route::get('personal', ['uses' => 'FrontController@personal', 'as' => 'front.personal']);
// Route::get('kiyaku', ['uses' => 'FrontController@kiyaku', 'as' => 'front.kiyaku']);
// Route::get('pp', ['uses' => 'FrontController@pp', 'as' => 'front.pp']);


// Route::get('news', ['uses' => 'Front\NewsController@index', 'as' => 'front.news.index']);
// Route::get('news/{id}', ['uses' => 'Front\NewsController@show', 'as' => 'front.news.show']);

// Route::get('schedule/groups/{groups_id?}/{period?}', ['uses' => 'Front\ScheduleController@index', 'as' => 'front.schedule.index']);
// Route::get('schedule/{group_id}/{period?}', ['uses' => 'Front\ScheduleController@group', 'as' => 'front.schedule.group']);

// Route::get('venue', ['uses' => 'Front\VenueController@index', 'as' => 'front.venue.index']);
// Route::get('venue/{id}', ['uses' => 'Front\VenueController@show', 'as' => 'front.venue.show']);

// Route::get('teams/period/{period?}', ['uses' => 'Front\TeamController@index', 'as' => 'front.team.index']);
// Route::get('team/{id}', ['uses' => 'Front\TeamController@show', 'as' => 'front.team.show']);

// Route::get('result/groups/{groups_id?}/{period?}', ['uses' => 'Front\ResultController@index', 'as' => 'front.result.index']);
// Route::get('result/group/{group_id?}/{period?}', ['uses' => 'Front\ResultController@group', 'as' => 'front.result.group']);
// Route::get('result/{id}', ['uses' => 'Front\ResultController@show', 'as' => 'front.result.show']);

// Route::get('table/groups/{groups_id?}/{yyyy?}/{period?}', ['uses' => 'Front\PcLeagueController@table_groups', 'as' => 'front.table.groups']);
// Route::get('table/index/{group_id?}/{yyyy?}', ['uses' => 'Front\PcLeagueController@table', 'as' => 'front.table.index']);
// // Route::get('table/{id}',['uses'=>'Front\PcLeagueController@show','as'=>'front.table.show']);
// Route::get('order/groups/{groups_id?}/{yyyy?}/{period?}', ['uses' => 'Front\PcLeagueController@order_groups', 'as' => 'front.order.index']);
// Route::get('order/{group_id?}/{yyyy?}/{period?}', ['uses' => 'Front\PcLeagueController@order', 'as' => 'front.order.groups']);
// // Route::get('order/{id}',['uses'=>'Front\PcLeagueController@show','as'=>'front.order.show']);
// Route::get('match/{group_id?}/{yyyy?}/{period?}', ['uses' => 'Front\PcLeagueController@match', 'as' => 'front.match.index']);
// // Route::get('match/{id}',['uses'=>'Front\PcLeagueController@show','as'=>'front.match.show']);
// Route::get('ranking/groups/{groups_id?}/{yyyy?}/{period?}', ['uses' => 'Front\PcLeagueController@ranking_groups', 'as' => 'front.ranking.groups']);


// Route::get('gallery/groups/{groups_id?}/{yyyy?}', ['uses' => 'Front\GalleryController@index', 'as' => 'front.gallery.index']);
// Route::get('gallery/group/{group_id?}',['uses'=>'Front\GalleryController@group','as'=>'front.gallery.group']);
// Route::get('gallery/{id}',['uses'=>'Front\GalleryController@show','as'=>'front.gallery.show']);

// Route::get('sports/{sports}',['uses'=>'FrontController@sports','as'=>'front.sports']);

// Route::get('area/{pref}',['uses'=>'FrontController@area','as'=>'front.area']);
// Route::get('age/{age}',['uses'=>'FrontController@age','as'=>'front.age']);
// //Route::get('detail/{id}',['uses'=>'FrontController@detail','as'=>'front.detail']);
// //Route::get('news/{id}',['uses'=>'Front\NewsController@show','as'=>'front.news.show']);


// Route::get('document/api',['uses'=>'Front\DocumentController@api','as'=>'front.document.api']);

// Route::get('api/order/{league_id}',['uses'=>'Api\LeagueController@order','as'=>'api.league.order']);
// Route::get('api/table/{league_id}',['uses'=>'Api\LeagueController@table','as'=>'api.league.table']);
// Route::get('api/match/{league_id}',['uses'=>'Api\LeagueController@match','as'=>'api.league.match']);

//リーグ
// Route::get('league',['uses'=>'Front\PcLeagueController@index','as'=>'front.league.index']);
// Route::get('league/order/{id}',['uses'=>'Front\PcLeagueController@order','as'=>'front.league.order']);
// Route::get('league/table/{id}',['uses'=>'Front\PcLeagueController@table','as'=>'front.league.table']);
// Route::get('league/match/{id}',['uses'=>'Front\PcLeagueController@match','as'=>'front.league.match']);
// Route::get('league/admin/{id}',['uses'=>'Front\PcLeagueController@admin','as'=>'front.league.admin']);

// Route::get('league/create',['uses'=>'Front\PcLeagueController@create','as'=>'front.league.create']);
// Route::post('league/store',['uses'=>'Front\PcLeagueController@store','as'=>'front.league.store']);
// Route::get('league/edit/{id}',['uses'=>'Front\PcLeagueController@edit','as'=>'front.league.edit']);
// Route::post('league/update',['uses'=>'Front\PcLeagueController@update','as'=>'front.league.update']);
// Route::post('league/delete',['uses'=>'Front\PcLeagueController@delete','as'=>'front.league.delete']);

// Route::get('match/create',['uses'=>'Front\PcMatchController@create','as'=>'front.match.create']);
// Route::post('match/store',['uses'=>'Front\PcMatchController@store','as'=>'front.match.store']);
// Route::get('match/edit/{id}',['uses'=>'Front\PcMatchController@edit','as'=>'front.match.edit']);
// Route::post('match/update',['uses'=>'Front\PcMatchController@update','as'=>'front.match.update']);
// Route::post('match/delete',['uses'=>'Front\PcMatchController@delete','as'=>'front.match.delete']);

// Route::get('comment/create/{leagues_id}/{match_id}',['uses'=>'Front\PcCommentController@create','as'=>'front.comment.create']);
// Route::post('comment/store',['uses'=>'Front\PcCommentController@store','as'=>'front.comment.store']);
// Route::post('comment/store0',['uses'=>'Front\PcCommentController@store0','as'=>'front.comment.store0']);
// Route::get('comment/edit/{id}',['uses'=>'Front\PcCommentController@edit','as'=>'front.comment.edit']);
// Route::post('comment/update',['uses'=>'Front\PcCommentController@update','as'=>'front.comment.update']);
// Route::post('comment/delete',['uses'=>'Front\PcCommentController@delete','as'=>'front.comment.delete']);


Route::get('cp/team', ['uses' => 'Team\Main2Controller@top', 'as' => 'team.top']);

Route::get('cp/team/starter/{id}', ['uses' => 'Team\Main2Controller@starter_edit', 'as' => 'team.starter.edit']);
Route::get('cp/team/starter/print/{id}', ['uses' => 'Team\Main2Controller@starter_print', 'as' => 'team.starter.print']);
Route::post('cp/team/starter', ['uses' => 'Team\Main2Controller@starter_update', 'as' => 'team.starter.update']);

Route::get('cp/team/check/{id}', ['uses' => 'Team\Main2Controller@check', 'as' => 'team.check']);

Route::get('cp/team/create', ['uses' => 'Team\Main2Controller@edit', 'as' => 'team.info.create']);
Route::post('cp/team/confirm', ['uses' => 'Team\Main2Controller@confirm', 'as' => 'team.info.confirm']);
Route::post('cp/team/store', ['uses' => 'Team\Main2Controller@store', 'as' => 'team.info.store']);
Route::get('cp/team/edit', ['uses' => 'Team\Main2Controller@edit', 'as' => 'team.info.edit']);
Route::post('cp/team/update', ['uses' => 'Team\Main2Controller@update', 'as' => 'team.info.update']);

Route::get('cp/team/account', ['uses' => 'Team\Main2Controller@account', 'as' => 'team.account.edit']);
Route::post('cp/team/email/update', ['uses' => 'Team\Main2Controller@email_update', 'as' => 'team.email.update']);
Route::post('cp/team/password/update', ['uses' => 'Team\Main2Controller@password_update', 'as' => 'team.password.update']);

Route::get('cp/team/player', ['uses' => 'Team\PlayerController@index', 'as' => 'team.player.index']);
Route::get('cp/team/player/create', ['uses' => 'Team\PlayerController@create', 'as' => 'team.player.create']);
// Route::post('cp/team/player/confirm',['uses'=>'Team\PlayerController@confirm','as'=>'team.player.confirm']);
Route::post('cp/team/player/store', ['uses' => 'Team\PlayerController@store', 'as' => 'team.player.store']);
Route::get('cp/team/player/edit/{id}', ['uses' => 'Team\PlayerController@edit', 'as' => 'team.player.edit']);
// Route::post('cp/team/player/edit/confirm',['uses'=>'Team\PlayerController@editConfirm','as'=>'team.player.edit.confirm']);
Route::post('cp/team/player/update', ['uses' => 'Team\PlayerController@update', 'as' => 'team.player.update']);
Route::post('cp/team/player/delete', ['uses' => 'Team\PlayerController@delete', 'as' => 'team.player.delete']);
Route::post('cp/team/player/selected_delete', ['uses' => 'Team\PlayerController@selected_delete', 'as' => 'team.player.selected_delete']);

// Route::post('cp/team/player/transfer',['uses'=>'Team\PlayerController@transfer','as'=>'team.player.transfer']);
Route::post('cp/team/player/import', ['uses' => 'Team\PlayerController@import', 'as' => 'team.player.import']);

Route::get('cp/team/formation', ['uses' => 'Team\FormationController@index', 'as' => 'team.formation.index']);
Route::post('cp/team/formation/update', ['uses' => 'Team\FormationController@update', 'as' => 'team.formation.update']);


Route::get('cp/team/league', ['uses' => 'Team\LeagueController@index', 'as' => 'team.league.index']);
Route::get('cp/team/league/create', ['uses' => 'Team\LeagueController@create', 'as' => 'team.league.create']);
Route::post('cp/team/league', ['uses' => 'Team\LeagueController@store', 'as' => 'team.league.store']);
Route::get('cp/team/league/show/{id}', ['uses' => 'Team\LeagueController@show', 'as' => 'team.league.show']);
Route::get('cp/team/league/edit/{id}', ['uses' => 'Team\LeagueController@edit', 'as' => 'team.league.edit']);
Route::post('cp/team/league/update', ['uses' => 'Team\LeagueController@update', 'as' => 'team.league.update']);
Route::post('cp/team/league/delete/{id}', ['uses' => 'Team\LeagueController@delete', 'as' => 'team.league.delete']);

Route::get('cp/team/league/table/{id}', ['uses' => 'Team\LeagueController@table', 'as' => 'team.league.table']);
Route::get('cp/team/league/order/{id}', ['uses' => 'Team\LeagueController@order', 'as' => 'team.league.order']);
Route::get('cp/team/league/match/all/{id}', ['uses' => 'Team\LeagueController@match_all', 'as' => 'team.league.match.all']);
Route::get('cp/team/league/match/self/{id}', ['uses' => 'Team\LeagueController@match_self', 'as' => 'team.league.match.self']);
Route::get('cp/team/league/goals/{id}', ['uses' => 'Team\LeagueController@goals', 'as' => 'team.league.goals']);
Route::get('cp/team/league/block/{id}', ['uses' => 'Team\LeagueController@block', 'as' => 'team.league.block']);
Route::get('cp/team/league/warning/{id}/{nendo}', ['uses' => 'Team\LeagueController@warning', 'as' => 'team.league.warning']);
Route::get('cp/team/league/warning/match/{id}/{player_id}/{nendo}', ['uses' => 'Team\LeagueController@wmatch', 'as' => 'team.league.wmatch']);

Route::post('cp/team/match', ['uses' => 'Team\MatchController@store', 'as' => 'team.match.store']);
Route::get('cp/team/match/edit/{id}', ['uses' => 'Team\MatchController@edit', 'as' => 'team.match.edit']);
Route::get('cp/team/match/day/edit/{id}', ['uses' => 'Team\MatchController@day_edit', 'as' => 'team.match.day.edit']);
Route::post('cp/team/match/day/update/{id}', ['uses' => 'Team\MatchController@day_update', 'as' => 'team.match.day.update']);
Route::post('cp/team/match/update', ['uses' => 'Team\MatchController@update', 'as' => 'team.match.update']);
Route::get('cp/team/match/venue/edit/{id}', ['uses' => 'Team\MatchController@venue_edit', 'as' => 'team.match.venue.edit']);
Route::post('cp/team/match/venue/update/{id}', ['uses' => 'Team\MatchController@venue_update', 'as' => 'team.match.venue.update']);

Route::get('cp/team/match/group_photo/edit/{id}', ['uses' => 'Team\MatchGroupPhotoController@edit', 'as' => 'team.match.group_photo.edit']);
Route::post('cp/team/match/group_photo/update', ['uses' => 'Team\MatchGroupPhotoController@update', 'as' => 'team.match.group_photo.update']);

Route::get('cp/team/match/gallery/edit/{id}', ['uses' => 'Team\MatchGalleryController@edit', 'as' => 'team.match.gallery.edit']);
Route::post('cp/team/match/gallery/update', ['uses' => 'Team\MatchGalleryController@update', 'as' => 'team.match.gallery.update']);

Route::get('cp/team/news', ['uses' => 'Team\NewsController@index', 'as' => 'team.news.index']);
Route::get('cp/team/news/{id}', ['uses' => 'Team\NewsController@show', 'as' => 'team.news.show']);



Route::get('admin', ['uses' => 'Admin\ConfigController@getIndex', 'as' => 'admin.top']);
Route::post('admin', ['uses' => 'Admin\ConfigController@memo', 'as' => 'admin.memo.store']);

Route::get('admin/config', ['uses' => 'Admin\ConfigController@getConfig', 'as' => 'admin.config']);
Route::post('admin/config', 'Admin\ConfigController@postConfig');

// Route::get('admin/user',['uses'=>'Admin\UserController@index','as'=>'admin.user.index']);
// Route::get('admin/user/show/{id}',['uses'=>'Admin\UserController@show','as'=>'admin.user.show']);
// Route::post('admin/user',['uses'=>'Admin\UserController@update','as'=>'admin.user.update']);
// Route::get('admin/user/destroy/{id}',['uses'=>'Admin\UserController@destroy','as'=>'admin.user.destroy']);
// Route::post('admin/user/destroy',['uses'=>'Admin\UserController@destroyPost','as'=>'admin.user.destroyPost']);

Route::get('admin/user', ['uses' => 'Admin\UserController@index', 'as' => 'admin.user.index']);
//Route::get('admin/user/create',['uses'=>'Admin\UserController@create','as'=>'admin.user.create']);
//Route::post('admin/user',['uses'=>'Admin\UserController@store','as'=>'admin.user.store']);
Route::get('admin/user/edit/{id}', ['uses' => 'Admin\UserController@edit', 'as' => 'admin.user.edit']);
Route::post('admin/user/update', ['uses' => 'Admin\UserController@update', 'as' => 'admin.user.update']);
Route::get('admin/user/delete/{id}', ['uses' => 'Admin\UserController@delete', 'as' => 'admin.user.delete']);

Route::get('admin/venue', ['uses' => 'Admin\VenueController@index', 'as' => 'admin.venue.index']);
Route::get('admin/venue/create', ['uses' => 'Admin\VenueController@create', 'as' => 'admin.venue.create']);
Route::post('admin/venue', ['uses' => 'Admin\VenueController@store', 'as' => 'admin.venue.store']);
Route::get('admin/venue/edit/{id}', ['uses' => 'Admin\VenueController@edit', 'as' => 'admin.venue.edit']);
Route::post('admin/venue/update', ['uses' => 'Admin\VenueController@update', 'as' => 'admin.venue.update']);
Route::get('admin/venue/delete/{id}', ['uses' => 'Admin\VenueController@delete', 'as' => 'admin.venue.delete']);

Route::get('admin/organization', ['uses' => 'Admin\OrganizationController@index', 'as' => 'admin.organization.index']);
Route::get('admin/organization/create', ['uses' => 'Admin\OrganizationController@create', 'as' => 'admin.organization.create']);
Route::post('admin/organization', ['uses' => 'Admin\OrganizationController@store', 'as' => 'admin.organization.store']);
Route::get('admin/organization/edit/{id}', ['uses' => 'Admin\OrganizationController@edit', 'as' => 'admin.organization.edit']);
Route::post('admin/organization/update', ['uses' => 'Admin\OrganizationController@update', 'as' => 'admin.organization.update']);
Route::get('admin/organization/delete/{id}', ['uses' => 'Admin\OrganizationController@delete', 'as' => 'admin.organization.delete']);

Route::get('admin/news', ['uses' => 'Admin\NewsController@index', 'as' => 'admin.news.index']);
Route::get('admin/news/create', ['uses' => 'Admin\NewsController@create', 'as' => 'admin.news.create']);
Route::post('admin/news', ['uses' => 'Admin\NewsController@store', 'as' => 'admin.news.store']);
Route::get('admin/news/edit/{id}', ['uses' => 'Admin\NewsController@edit', 'as' => 'admin.news.edit']);
Route::post('admin/news/update', ['uses' => 'Admin\NewsController@update', 'as' => 'admin.news.update']);
Route::get('admin/news/delete/{id}', ['uses' => 'Admin\NewsController@delete', 'as' => 'admin.news.delete']);

Route::get('admin/news2', ['uses' => 'Admin\News2Controller@index', 'as' => 'admin.news2.index']);
Route::get('admin/news2/create', ['uses' => 'Admin\News2Controller@create', 'as' => 'admin.news2.create']);
Route::post('admin/news2', ['uses' => 'Admin\News2Controller@store', 'as' => 'admin.news2.store']);
Route::get('admin/news2/edit/{id}', ['uses' => 'Admin\News2Controller@edit', 'as' => 'admin.news2.edit']);
Route::post('admin/news2/update', ['uses' => 'Admin\News2Controller@update', 'as' => 'admin.news2.update']);
Route::get('admin/news2/delete/{id}', ['uses' => 'Admin\News2Controller@delete', 'as' => 'admin.news2.delete']);

Route::get('admin/league', ['uses' => 'Admin\LeagueController@index', 'as' => 'admin.league.index']);
Route::get('admin/league/create', ['uses' => 'Admin\LeagueController@create', 'as' => 'admin.league.create']);
Route::post('admin/league', ['uses' => 'Admin\LeagueController@store', 'as' => 'admin.league.store']);
Route::get('admin/league/show/{id}', ['uses' => 'Admin\LeagueController@show', 'as' => 'admin.league.show']);
Route::get('admin/league/edit/{id}', ['uses' => 'Admin\LeagueController@edit', 'as' => 'admin.league.edit']);
Route::post('admin/league/update', ['uses' => 'Admin\LeagueController@update', 'as' => 'admin.league.update']);
Route::get('admin/league/delete/{id}', ['uses' => 'Admin\LeagueController@delete', 'as' => 'admin.league.delete']);
Route::get('admin/league/table/{id}', ['uses' => 'Admin\LeagueController@table', 'as' => 'admin.league.table']);

Route::get('admin/league/closing/{id}', ['uses' => 'Admin\LeagueController@closing', 'as' => 'admin.league.closing']);
Route::post('admin/league/close', ['uses' => 'Admin\LeagueController@close', 'as' => 'admin.league.close']);

Route::get('admin/match/{league_id}', ['uses' => 'Admin\MatchController@index', 'as' => 'admin.match.index']);
Route::get('admin/match/create/{league_id}', ['uses' => 'Admin\MatchController@create', 'as' => 'admin.match.create']);
Route::post('admin/match', ['uses' => 'Admin\MatchController@store', 'as' => 'admin.match.store']);
Route::get('admin/match/edit/{id}', ['uses' => 'Admin\MatchController@edit', 'as' => 'admin.match.edit']);
Route::post('admin/match/update', ['uses' => 'Admin\MatchController@update', 'as' => 'admin.match.update']);
Route::get('admin/match/delete/{id}', ['uses' => 'Admin\MatchController@delete', 'as' => 'admin.match.delete']);

Route::get('admin/result', ['uses' => 'Admin\ResultController@index', 'as' => 'admin.result.index']);
Route::get('admin/result/edit/{id}', ['uses' => 'Admin\ResultController@edit', 'as' => 'admin.result.edit']);
Route::post('admin/result/update', ['uses' => 'Admin\ResultController@update', 'as' => 'admin.result.update']);
Route::get('admin/result/group_photo/edit/{id}', ['uses' => 'Admin\ResultGroupPhotoController@edit', 'as' => 'admin.result.group_photo.edit']);
Route::post('admin/result/group_photo/update', ['uses' => 'Admin\ResultGroupPhotoController@update', 'as' => 'admin.result.group_photo.update']);

Route::get('admin/result/gallery/edit/{id}', ['uses' => 'Admin\ResultGalleryController@edit', 'as' => 'admin.result.gallery.edit']);
Route::post('admin/result/gallery/update', ['uses' => 'Admin\ResultGalleryController@update', 'as' => 'admin.result.gallery.update']);

Route::get('admin/league/comment/{league_id}', ['uses' => 'Admin\CommentController@index', 'as' => 'admin.comment.index']);
// Route::get('admin/comment/edit/{id}',['uses'=>'Admin\CommentController@edit','as'=>'admin.comment.edit']);
// Route::post('admin/comment/update',['uses'=>'Admin\CommentController@update','as'=>'admin.comment.update']);
// Route::get('admin/comment/delete/{id}',['uses'=>'Admin\CommentController@delete','as'=>'admin.comment.delete']);

Route::get('admin/vpoint', ['uses' => 'Admin\VpointController@index', 'as' => 'admin.vpoint.index']);
Route::get('admin/vpoint/create', ['uses' => 'Admin\VpointController@create', 'as' => 'admin.vpoint.create']);
Route::post('admin/vpoint', ['uses' => 'Admin\VpointController@store', 'as' => 'admin.vpoint.store']);
Route::get('admin/vpoint/edit/{id}', ['uses' => 'Admin\VpointController@edit', 'as' => 'admin.vpoint.edit']);
Route::post('admin/vpoint/update', ['uses' => 'Admin\VpointController@update', 'as' => 'admin.vpoint.update']);
Route::get('admin/vpoint/delete/{id}', ['uses' => 'Admin\VpointController@delete', 'as' => 'admin.vpoint.delete']);

Route::get('admin/team', ['uses' => 'Admin\TeamController@index', 'as' => 'admin.team.index']);
Route::get('admin/team/create', ['uses' => 'Admin\TeamController@create', 'as' => 'admin.team.create']);
Route::post('admin/team', ['uses' => 'Admin\TeamController@store', 'as' => 'admin.team.store']);
Route::get('admin/team/edit/{id}', ['uses' => 'Admin\TeamController@edit', 'as' => 'admin.team.edit']);
Route::post('admin/team/update', ['uses' => 'Admin\TeamController@update', 'as' => 'admin.team.update']);
Route::get('admin/team/delete/{id}', ['uses' => 'Admin\TeamController@delete', 'as' => 'admin.team.delete']);

Route::get('admin/team/player', ['uses' => 'Admin\PlayerController@index', 'as' => 'admin.team.player.index']);
// Route::get('admin/team/create',['uses'=>'Admin\PlayerController@create','as'=>'admin.team.create']);
// Route::post('admin/team',['uses'=>'Admin\PlayerController@store','as'=>'admin.team.store']);
Route::get('admin/team/player/edit/{id}', ['uses' => 'Admin\PlayerController@edit', 'as' => 'admin.team.player.edit']);
Route::post('admin/team/player/update', ['uses' => 'Admin\PlayerController@update', 'as' => 'admin.team.player.update']);
// Route::get('admin/team/delete/{id}',['uses'=>'Admin\PlayerController@delete','as'=>'admin.team.delete']);

// Route::get('admin/wanted',['uses'=>'Admin\WantedController@index','as'=>'admin.wanted.index']);
// Route::get('admin/wanted/create',['uses'=>'Admin\WantedController@create','as'=>'admin.wanted.create']);
// Route::post('admin/wanted',['uses'=>'Admin\WantedController@store','as'=>'admin.wanted.store']);
// Route::get('admin/wanted/edit/{id}',['uses'=>'Admin\WantedController@edit','as'=>'admin.wanted.edit']);
// Route::post('admin/wanted/update',['uses'=>'Admin\WantedController@update','as'=>'admin.wanted.update']);
// Route::get('admin/wanted/delete/{id}',['uses'=>'Admin\WantedController@delete','as'=>'admin.wanted.delete']);

Route::get('admin/block', ['uses' => 'Admin\PlayerController@getBlock', 'as' => 'admin.block.index']);
Route::get('admin/warning', ['uses' => 'Admin\PlayerController@getWarning', 'as' => 'admin.warning.index']);
Route::get('admin/warning/year/team/{nendo}', ['uses' => 'Admin\PlayerController@getYearWarning', 'as' => 'admin.warning.year']);
Route::get('admin/warning/year/player/{id}/{nendo}', ['uses' => 'Admin\PlayerController@getYearPlayerWarning', 'as' => 'admin.warning.year.player']);
Route::get('admin/warning/edit/{id}', ['uses' => 'Admin\PlayerController@editWarning', 'as' => 'admin.warning.edit']);
Route::post('admin/warning/update', ['uses' => 'Admin\PlayerController@updateWarning', 'as' => 'admin.warning.update']);

Route::get('admin/sports', ['uses' => 'Admin\SportsController@index', 'as' => 'admin.sports.index']);
Route::get('admin/sports/create', ['uses' => 'Admin\SportsController@create', 'as' => 'admin.sports.create']);
Route::post('admin/sports', ['uses' => 'Admin\SportsController@store', 'as' => 'admin.sports.store']);
Route::get('admin/sports/edit/{id}', ['uses' => 'Admin\SportsController@edit', 'as' => 'admin.sports.edit']);
Route::post('admin/sports/update', ['uses' => 'Admin\SportsController@update', 'as' => 'admin.sports.update']);
Route::get('admin/sports/delete/{id}', ['uses' => 'Admin\SportsController@delete', 'as' => 'admin.sports.delete']);

// Route::post('admin/memo',['uses'=>'Admin\MemoController@index','as'=>'admin.memo.store']);

Route::get('admin/template', ['uses' => 'Admin\TemplateController@edit', 'as' => 'admin.template.edit']);
Route::post('admin/template', ['uses' => 'Admin\TemplateController@update', 'as' => 'admin.template.update']);

Route::get('admin/option', ['uses' => 'Admin\OptionController@index', 'as' => 'admin.option.index']);
Route::post('admin/option', ['uses' => 'Admin\OptionController@store', 'as' => 'admin.option.store']);

/// LOGIN/LOGOUT -----------------------------------------------------------------

Route::get('authorize', ['uses' => 'AuthController@authorized']);
Route::get('email_update', ['uses' => 'AuthController@email_update']);

Route::get('/', ['uses' => 'AuthController@getLogin', 'as' => 'login']);
Route::post('login', 'AuthController@postLogin');
Route::get('logout', ['uses' => 'AuthController@getLogout', 'as' => 'logout']);

Route::get('register', ['uses' => 'AuthController@getRegister', 'as' => 'register']);
Route::post('regist/confirm', ['uses' => 'AuthController@registConfirm', 'as' => 'regist.confirm']);
Route::post('regist/completed', ['uses' => 'AuthController@registCompleted', 'as' => 'regist.completed']);
Route::get('regist/completed', ['uses' => 'AuthController@getRegistCompleted', 'as' => 'regist.finished']);

Route::get('reminder', ['uses' => 'AuthController@getReminder', 'as' => 'reminder']);
Route::post('reminder', 'AuthController@postReminder');

// Route::get('{provider}/authorize', function($provider)
// {
//   return Socialite::with($provider)->redirect();
// });

// Route::get('{provider}/login', function($provider)
// {

//   $userData = Socialite::with($provider)->user();
  
//   //dd($provider);

//   $id= $userData->getId();
//   if($provider!='twitter'){
//     $email = $userData->getEmail();
//   }else{
//     $email = 'dummy@hoge.com';
//   }
//   $name = $userData->getName();
//   //$nickname = $userData->getNickname();
//   $nickname = '';
//   $avatar = $userData->getAvatar();

//   // twitterがメールアドレス取得できない…
//   // if(is_null($email) || $email=='')
//   //   return "メールアドレスが登録されていないようです。メールアドレスは必須です";

//   if(App\User::where('oauth_id',$id)->where('oauth',$provider)->where('is_active',1)->count()!=1){
//     $user = App\User::create([
//       'oauth_id'=>$id,
//       'nickname' => isset($nickname)?$nickname:'名無し',
//       'name' => isset($name)?$name:'名無し',
//       'email'    => $email,
//       'avatar'   => $avatar,
//       'oauth' => $provider,
//       //'birthday' => $userData->user_birthday,
//       //'gender' => $userData->user['gender'],
//       'is_active' => 1,
//       'role' => 'user'
//     ]);
//     // if(App\User::where('oauth_id',$id)->where('is_active',1)->count()==1){
//     //   return "すでにそのアカウントは登録されています";
//     // }else{
//     // }
//   }

//   //Auth::login($user);
//   $res = App\User::where('oauth_id',$id)->where('oauth',$provider)->firstOrFail();
//   Session::put('userid', $res->id);
//   Session::put('oauth', $res->oauth);
//   Session::put('avatar', $res->avatar);
//   Session::put('email', $res->email);
//   Session::put('role', $res->role);
//   if($res->role=='user'){
//     return \Redirect::to('/mypage');
//   }else{
//     return \Redirect::to('/admin');
//   }
// });
