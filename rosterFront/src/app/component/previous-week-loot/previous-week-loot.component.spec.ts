import { async, ComponentFixture, TestBed } from '@angular/core/testing';

import { PreviousWeekLootComponent } from './previous-week-loot.component';

describe('PreviousWeekLootComponent', () => {
  let component: PreviousWeekLootComponent;
  let fixture: ComponentFixture<PreviousWeekLootComponent>;

  beforeEach(async(() => {
    TestBed.configureTestingModule({
      declarations: [ PreviousWeekLootComponent ]
    })
    .compileComponents();
  }));

  beforeEach(() => {
    fixture = TestBed.createComponent(PreviousWeekLootComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
