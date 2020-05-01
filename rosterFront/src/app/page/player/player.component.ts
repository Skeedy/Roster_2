import {Component, ComponentFactoryResolver, OnInit, Output, ViewChild, ViewContainerRef} from '@angular/core';
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
export class PlayerComponent implements OnInit{
  @ViewChild(AddPlayerComponent)
  players: Player[];
  public nbPlayer : number;
  public maxPlayer : number;
  constructor(public viewContainerRef: ViewContainerRef,
              private componentFactoryResolver: ComponentFactoryResolver,
              public searchServ: PlayerListService,
              public rosterServ: RosterService) {
  }

  ngOnInit(): void {
    this.maxPlayer = 8;
    this.rosterServ.getRosters().subscribe(data => {
      this.players = data.player;
      this.nbPlayer = this.players.length;
    });
  }

  addCharForm() {
    const componentFactory = this.componentFactoryResolver.resolveComponentFactory(AddPlayerComponent);
    this.viewContainerRef.createComponent(componentFactory)
    this.nbPlayer ++
  }

  submitPlayers() {
    this.searchServ.postPlayer().subscribe((data) => {
      console.log(data)
    })
  }
}
