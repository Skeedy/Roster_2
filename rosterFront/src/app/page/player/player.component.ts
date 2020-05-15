import {
  AfterViewInit,
  Component,
  ComponentFactoryResolver, Input,
  OnInit,
  ViewChild,
  ViewContainerRef
} from '@angular/core';
import {Player} from "../../class/player";
import {AddPlayerComponent} from "../../component/add-player/add-player.component";
import {PlayerListService} from "../../service/player-list.service";
import {RosterService} from "../../service/roster.service";
import {Roster} from "../../class/roster";
import {JobService} from "../../service/job.service";


@Component({
  selector: 'app-player',
  templateUrl: './player.component.html',
  styleUrls: ['./player.component.scss']
})
export class PlayerComponent implements OnInit, AfterViewInit{
  @ViewChild(AddPlayerComponent)

  public maxPlayer = 8;
  constructor(public viewContainerRef: ViewContainerRef,
              private componentFactoryResolver: ComponentFactoryResolver,
              public searchServ: PlayerListService,
              public rosterServ: RosterService,
              public jobServ: JobService) {
  }

  ngOnInit(): void {
    this.rosterServ.getRosters();
    this.jobServ.getJobs();
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
    this.rosterServ.postPlayer().subscribe((data) => {
      if (data) {
        this.rosterServ.getRosters();
        this.searchServ.isSubmitted = false;
        this.searchServ.isDone = true;
        this.searchServ.formUp=false;
      }
    });
  }
}
