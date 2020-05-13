import {
  AfterViewInit,
  Component,
  ComponentFactoryResolver, Input,
  OnInit,
  Output,
  ViewChild,
  ViewContainerRef
} from '@angular/core';
import {Player} from "../../class/player";
import {AddPlayerComponent} from "../../component/add-player/add-player.component";
import {PlayerListService} from "../../service/player-list.service";
import {RosterService} from "../../service/roster.service";
import {Roster} from "../../class/roster";


@Component({
  selector: 'app-player',
  templateUrl: './player.component.html',
  styleUrls: ['./player.component.scss']
})
export class PlayerComponent implements OnInit, AfterViewInit{
  @ViewChild(AddPlayerComponent)
  roster: any;
  public maxPlayer = 8;
  constructor(public viewContainerRef: ViewContainerRef,
              private componentFactoryResolver: ComponentFactoryResolver,
              public searchServ: PlayerListService,
              public rosterServ: RosterService) {
  }

  ngOnInit(): void {
    this.rosterServ.getRosters();
    console.log('nbFrom : ' + this.searchServ.nbForm +'/ nbPlayer : '+ this.rosterServ.nbPlayer)
  }
  ngAfterViewInit() {
  }

  addCharForm() {
    const componentFactory = this.componentFactoryResolver.resolveComponentFactory(AddPlayerComponent);
    this.viewContainerRef.createComponent(componentFactory)
    this.searchServ.formUp = true;
    this.searchServ.nbForm++;
    console.log('nbFrom : ' + this.searchServ.nbForm +'/ nbPlayer : '+ this.rosterServ.nbPlayer)
    console.log(this.rosterServ.nbPlayer);
  }

  submitPlayers() {
    this.searchServ.postPlayer().subscribe((data) => {
    })
  }
}
