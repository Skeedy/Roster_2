import { NgModule } from '@angular/core';
import { Routes, RouterModule } from '@angular/router';

import { RosterComponent} from './page/roster/roster.component';
import { AppComponent } from './app.component';
import {AuthComponent} from "./page/auth/auth.component";
import {PlayerComponent} from "./page/player/player.component";
import {IsSignedInGuard} from "./guard/is-signed-in.guard";
import {ItemComponent} from "./page/item/item.component";
import {HistoryComponent} from "./page/history/history.component";
import {ForgetPasswordComponent} from './page/forget-password/forget-password.component';
import {ResetPasswordComponent} from './page/reset-password/reset-password.component';
import {EditRosterComponent} from './page/edit-roster/edit-roster.component';

const routes: Routes = [
  { path: '', component: AuthComponent, data : { title: 'Login'} },
  { path: 'forget-password', component: ForgetPasswordComponent, data : { title: 'Forgot password'} },
  { path: 'reset-password', component: ResetPasswordComponent, data : { title: 'Reset password'} },
  { path: 'roster', component: RosterComponent, canActivate: [IsSignedInGuard], data : { title: 'Roster'} },
  { path: 'player', component: PlayerComponent, canActivate: [IsSignedInGuard], data : { title: 'Player'} },
  { path: 'history', component: HistoryComponent, canActivate: [IsSignedInGuard], data : { title: 'History'} },
  { path: 'item', component: ItemComponent, canActivate: [IsSignedInGuard], data : { title: 'Item'} },
  { path: 'edit-roster', component: EditRosterComponent, canActivate: [IsSignedInGuard], data : { title: 'Edit'} },
];

@NgModule({
  imports: [RouterModule.forRoot(routes)],
  exports: [RouterModule]
})
export class AppRoutingModule { }
