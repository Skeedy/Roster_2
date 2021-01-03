import { async, ComponentFixture, TestBed } from '@angular/core/testing';

import { PlayerLootsComponent } from './player-loots.component';

describe('PlayerLootsComponent', () => {
  let component: PlayerLootsComponent;
  let fixture: ComponentFixture<PlayerLootsComponent>;

  beforeEach(async(() => {
    TestBed.configureTestingModule({
      declarations: [ PlayerLootsComponent ]
    })
    .compileComponents();
  }));

  beforeEach(() => {
    fixture = TestBed.createComponent(PlayerLootsComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
