import { BrowserModule } from '@angular/platform-browser';
import { NgModule, Component } from '@angular/core';
import { APP_BASE_HREF} from '@angular/common';
import { FormsModule, ReactiveFormsModule } from '@angular/forms';

import { NgbModule } from '@ng-bootstrap/ng-bootstrap';
import { BrowserAnimationsModule } from '@angular/platform-browser/animations';
import {MatSidenavModule} from '@angular/material/sidenav';
import {MatAutocompleteModule} from '@angular/material/autocomplete';
import {MatBadgeModule} from '@angular/material/badge';
import {MatBottomSheetModule} from '@angular/material/bottom-sheet';
import {MatButtonModule} from '@angular/material/button';
import {MatButtonToggleModule} from '@angular/material/button-toggle';
import {MatCardModule} from '@angular/material/card';
import {MatCheckboxModule} from '@angular/material/checkbox';
import {MatChipsModule} from '@angular/material/chips';
import {MatStepperModule} from '@angular/material/stepper';
import {MatDatepickerModule} from '@angular/material/datepicker';
import {MatDialogModule} from '@angular/material/dialog';
import {MatDividerModule} from '@angular/material/divider';
import {MatExpansionModule} from '@angular/material/expansion';
import {MatGridListModule} from '@angular/material/grid-list';
import {MatIconModule} from '@angular/material/icon';
import {MatInputModule} from '@angular/material/input';
import {MatListModule} from '@angular/material/list';
import {MatMenuModule} from '@angular/material/menu';
import {MatNativeDateModule, MatRippleModule} from '@angular/material/core';
import {MatPaginatorModule} from '@angular/material/paginator';
import {MatProgressBarModule} from '@angular/material/progress-bar';
import {MatProgressSpinnerModule} from '@angular/material/progress-spinner';
import {MatRadioModule} from '@angular/material/radio';
import {MatSelectModule} from '@angular/material/select';
import {MatSliderModule} from '@angular/material/slider';
import {MatSlideToggleModule} from '@angular/material/slide-toggle';
import {MatSnackBarModule} from '@angular/material/snack-bar';
import {MatSortModule} from '@angular/material/sort';
import {MatTableModule} from '@angular/material/table';
import {MatTabsModule} from '@angular/material/tabs';
import {MatToolbarModule} from '@angular/material/toolbar';
import {MatTooltipModule} from '@angular/material/tooltip';
import {MatTreeModule} from '@angular/material/tree';
import {HTTP_INTERCEPTORS, HttpClientModule} from '@angular/common/http';

import { AppRoutingModule } from './app-routing.module';
import { AppComponent } from './app.component';
import { LoginComponent } from './component/login/login.component';
import { NewRosterComponent } from './component/new-roster/new-roster.component';
import { AuthComponent } from './page/auth/auth.component';
import { RosterComponent } from './page/roster/roster.component';
import { AddPlayerComponent } from './component/add-player/add-player.component';
import { PlayerComponent } from './page/player/player.component';
import { ImgPipe } from './pipe/img.pipe';
import { DeleteConfirmationComponent } from './component/delete-confirmation/delete-confirmation.component';
import { PlayerInfoComponent } from './component/player-info/player-info.component';
import { JobsComponent } from './component/jobs/jobs.component';
import { TankJobsPipe } from './pipe/tank-jobs.pipe';
import { HealerJobsPipe } from './pipe/healer-jobs.pipe';
import { RangeddpsPipe } from './pipe/rangeddps.pipe';
import { MeleedpsPipe } from './pipe/meleedps.pipe';
import { MagicdpsPipe } from './pipe/magicdps.pipe';
import { InstanceComponent } from './page/instance/instance.component';
import { PlayerShowComponent } from './component/player-show/player-show.component';
import { SelectGearComponent } from './component/select-gear/select-gear.component';
import {JwtInterceptor} from "./class/jwtinterceptor";
import {ErrorInterceptor} from "./class/errorinterceptor";
import { PoolComponent } from './component/pool/pool.component';
import { LootSlotComponent } from './component/loot-slot/loot-slot.component';
import { PlayerJobLootComponent } from './component/player-job-loot/player-job-loot.component';
import { WishlistComponent } from './component/wishlist/wishlist.component';
import { CurrentStuffComponent } from './component/current-stuff/current-stuff.component';
import { SelectCurrentComponent } from './component/select-current/select-current.component';
import { IsCofferPipe } from './pipe/is-coffer.pipe';
import { IsNotCofferPipe } from './pipe/is-not-coffer.pipe';
import { MeleeWeaponPipe } from './pipe/melee-weapon.pipe';
import { TankWeaponPipe } from './pipe/tank-weapon.pipe';
import { HealWeaponPipe } from './pipe/heal-weapon.pipe';
import { MagicWeaponPipe } from './pipe/magic-weapon.pipe';
import { RangedWeaponPipe } from './pipe/ranged-weapon.pipe';
import { IsUpgradePipe } from './pipe/is-upgrade.pipe';
import { UpgradeComponent } from './component/upgrade/upgrade.component';
import { SetUpgradeComponent } from './component/set-upgrade/set-upgrade.component';
import { UpgradePlayerJobComponent } from './component/upgrade-player-job/upgrade-player-job.component';
import { UpgradeSelectJobComponent } from './component/upgrade-select-job/upgrade-select-job.component';
import { ErrorBlockComponent } from './component/error-block/error-block.component';
import { SuccessBlockComponent } from './component/success-block/success-block.component';
import { LoadingBoxComponent } from './component/loading-box/loading-box.component';
import { PreviousLootComponent } from './component/previous-loot/previous-loot.component';
import { PreviousWeekLootComponent } from './component/previous-week-loot/previous-week-loot.component';
import { InstanceOnePipe } from './pipe/instance-one.pipe';
import { InstanceTwoPipe } from './pipe/instance-two.pipe';
import { InstanceThreePipe } from './pipe/instance-three.pipe';
import { InstanceFourPipe } from './pipe/instance-four.pipe';
import { PlayerLootsComponent } from './component/player-loots/player-loots.component';
import { ItemComponent } from './page/item/item.component';
import { CofferCountComponent } from './component/coffer-count/coffer-count.component';
import { PlayerItemLoopComponent } from './component/player-item-loop/player-item-loop.component';
import { TotalLootComponent } from './component/total-loot/total-loot.component';
import { PickUpLootComponent } from './component/pick-up-loot/pick-up-loot.component';
import { NewPlayerFormComponent } from './component/new-player-form/new-player-form.component';
import { HistoryComponent } from './page/history/history.component';
import { ForgetPasswordComponent } from './page/forget-password/forget-password.component';
import { ResetPasswordComponent } from './page/reset-password/reset-password.component';
import { WelcomeComponent } from './component/welcome/welcome.component';
import { EditRosterComponent } from './page/edit-roster/edit-roster.component';
import { DeleteRosterComponent } from './component/delete-roster/delete-roster.component';


@NgModule({
  declarations: [
    NewRosterComponent,
    AppComponent,
    LoginComponent,
    RosterComponent,
    AuthComponent,
    AddPlayerComponent,
    PlayerComponent,
    ImgPipe,
    DeleteConfirmationComponent,
    PlayerInfoComponent,
    JobsComponent,
    TankJobsPipe,
    HealerJobsPipe,
    RangeddpsPipe,
    MeleedpsPipe,
    MagicdpsPipe,
    InstanceComponent,
    PlayerShowComponent,
    SelectGearComponent,
    PoolComponent,
    LootSlotComponent,
    PlayerJobLootComponent,
    WishlistComponent,
    CurrentStuffComponent,
    SelectCurrentComponent,
    IsCofferPipe,
    IsNotCofferPipe,
    MeleeWeaponPipe,
    TankWeaponPipe,
    HealWeaponPipe,
    MagicWeaponPipe,
    RangedWeaponPipe,
    IsUpgradePipe,
    UpgradeComponent,
    SetUpgradeComponent,
    UpgradePlayerJobComponent,
    UpgradeSelectJobComponent,
    ErrorBlockComponent,
    SuccessBlockComponent,
    LoadingBoxComponent,
    PreviousLootComponent,
    PreviousWeekLootComponent,
    InstanceOnePipe,
    InstanceTwoPipe,
    InstanceThreePipe,
    InstanceFourPipe,
    PlayerLootsComponent,
    ItemComponent,
    CofferCountComponent,
    PlayerItemLoopComponent,
    TotalLootComponent,
    PickUpLootComponent,
    NewPlayerFormComponent,
    HistoryComponent,
    ForgetPasswordComponent,
    ResetPasswordComponent,
    WelcomeComponent,
    EditRosterComponent,
    DeleteRosterComponent,
  ],
  imports: [
    FormsModule, ReactiveFormsModule,
    HttpClientModule,
    MatAutocompleteModule,
    MatBadgeModule,
    MatBottomSheetModule,
    MatButtonModule,
    MatButtonToggleModule,
    MatCardModule,
    MatCheckboxModule,
    MatChipsModule,
    MatStepperModule,
    MatDatepickerModule,
    MatDialogModule,
    MatDividerModule,
    MatExpansionModule,
    MatGridListModule,
    MatIconModule,
    MatInputModule,
    MatListModule,
    MatMenuModule,
    MatNativeDateModule,
    MatPaginatorModule,
    MatProgressBarModule,
    MatProgressSpinnerModule,
    MatRadioModule,
    MatRippleModule,
    MatSelectModule,
    MatSidenavModule,
    MatSliderModule,
    MatSlideToggleModule,
    MatSnackBarModule,
    MatSortModule,
    MatTableModule,
    MatTabsModule,
    MatToolbarModule,
    MatTooltipModule,
    MatTreeModule,
    MatSidenavModule,
    BrowserModule,
    NgbModule,
    AppRoutingModule,
    BrowserAnimationsModule
  ],
  providers: [{ provide: HTTP_INTERCEPTORS, useClass: JwtInterceptor, multi: true},
              { provide: HTTP_INTERCEPTORS, useClass: ErrorInterceptor, multi: true}],
  bootstrap: [AppComponent],
  entryComponents: [AddPlayerComponent]
})
export class AppModule { }
