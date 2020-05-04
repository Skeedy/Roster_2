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
  players: Player[];
  roster: any;
  public maxPlayer : number;
  constructor(public viewContainerRef: ViewContainerRef,
              private componentFactoryResolver: ComponentFactoryResolver,
              public searchServ: PlayerListService,
              public rosterServ: RosterService) {
  }

  ngOnInit(): void {

  }
  ngAfterViewInit() {
    this.maxPlayer = 8;
    this.rosterServ.getRosters().subscribe(data => {
      this.roster = this.rosterServ._rosterSub.value;
      this.players = this.roster.player;
      this.searchServ.nbPlayer = this.players.length;
      console.log(this.players)
    });
  }

  addCharForm() {
    const componentFactory = this.componentFactoryResolver.resolveComponentFactory(AddPlayerComponent);
    this.viewContainerRef.createComponent(componentFactory)
    this.searchServ.nbPlayer ++;
    this.searchServ.formUp = true;
    this.searchServ.nbForm ++;
    console.log(this.searchServ.nbForm);
  }

  submitPlayers() {
    this.searchServ.postPlayer().subscribe((data) => {
    })
  }
}
