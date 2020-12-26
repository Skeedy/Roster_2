import { async, ComponentFixture, TestBed } from '@angular/core/testing';

import { PreviousLootComponent } from './previous-loot.component';

describe('PreviousLootComponent', () => {
  let component: PreviousLootComponent;
  let fixture: ComponentFixture<PreviousLootComponent>;

  beforeEach(async(() => {
    TestBed.configureTestingModule({
      declarations: [ PreviousLootComponent ]
    })
    .compileComponents();
  }));

  beforeEach(() => {
    fixture = TestBed.createComponent(PreviousLootComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
