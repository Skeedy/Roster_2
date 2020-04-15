import { NgModule } from '@angular/core';
import { Routes, RouterModule } from '@angular/router';
import { LoginComponent} from './page/login/login.component';
import { RosterComponent} from './page/roster/roster.component';
import { AppComponent } from './app.component';

const routes: Routes = [
  { path: 'login', component: LoginComponent, data : { title: 'Login'} },
  { path: 'roster', component: RosterComponent, data : { title: 'Roster'} },
];

@NgModule({
  imports: [RouterModule.forRoot(routes)],
  exports: [RouterModule]
})
export class AppRoutingModule { }
