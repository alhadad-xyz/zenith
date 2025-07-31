<x-layout title="Zenith - Calendar">
    <x-slot name="styles">
        <style>
            /* Calendar specific styles */

            /* Navbar styles are now in layout */

        .container {
            display: flex;
            min-height: calc(100vh - 120px);
            gap: 2rem;
            padding: 2rem;
            max-width: 100vw;
            overflow-x: hidden;
        }

        /* Calendar Section */
        .calendar-section {
            flex: 1;
            display: flex;
            flex-direction: column;
        }

        .calendar-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 2rem;
        }

        .header-left {
            display: flex;
            flex-direction: column;
        }

        .page-title {
            font-size: 3rem;
            font-weight: 800;
            color: #2d3e2e;
            letter-spacing: -0.03em;
            margin-bottom: 0.5rem;
        }

        .page-subtitle {
            font-size: 1.1rem;
            color: #6b7c6d;
            font-weight: 500;
        }

        .calendar-controls {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .month-nav {
            display: flex;
            align-items: center;
            gap: 1rem;
            background: rgba(255, 255, 255, 0.6);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.3);
            border-radius: 50px;
            padding: 0.75rem 1.5rem;
        }

        .nav-button {
            background: none;
            border: none;
            color: #6b7c6d;
            font-size: 1.2rem;
            cursor: pointer;
            padding: 0.5rem;
            border-radius: 50%;
            transition: all 0.2s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            width: 36px;
            height: 36px;
        }

        .nav-button:hover {
            background: rgba(255, 255, 255, 0.8);
            color: #2d3e2e;
            transform: scale(1.1);
        }

        .current-month {
            font-size: 1.2rem;
            font-weight: 700;
            color: #2d3e2e;
            min-width: 140px;
            text-align: center;
        }

        .view-toggle {
            display: flex;
            background: rgba(255, 255, 255, 0.6);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.3);
            border-radius: 50px;
            padding: 0.25rem;
        }

        .toggle-btn {
            background: none;
            border: none;
            padding: 0.75rem 1.5rem;
            border-radius: 50px;
            font-size: 0.9rem;
            font-weight: 600;
            color: #6b7c6d;
            cursor: pointer;
            transition: all 0.3s cubic-bezier(0.23, 1, 0.32, 1);
            font-family: 'Inter', sans-serif;
        }

        .toggle-btn.active {
            background: rgba(255, 255, 255, 0.9);
            color: #2d3e2e;
            box-shadow: 0 4px 16px rgba(45, 62, 46, 0.1);
        }

        /* Calendar Grid */
        .calendar-grid {
            flex: 1;
            background: rgba(255, 255, 255, 0.4);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.3);
            border-radius: 24px;
            padding: 2rem;
            overflow: hidden;
            position: relative;
        }

        /* Calendar Views */
        .calendar-view {
            display: none;
            height: 100%;
        }

        .calendar-view.active {
            display: block;
        }

        .calendar-days-header {
            display: grid;
            grid-template-columns: repeat(7, 1fr);
            gap: 1px;
            margin-bottom: 1rem;
        }

        .day-header {
            text-align: center;
            font-size: 0.9rem;
            font-weight: 600;
            color: #6b7c6d;
            padding: 1rem 0;
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }

        /* Month View */
        .calendar-days {
            display: grid;
            grid-template-columns: repeat(7, 1fr);
            grid-template-rows: repeat(6, 1fr);
            gap: 1px;
            height: calc(100% - 60px);
        }

        /* Week View */
        .week-view {
            display: flex;
            flex-direction: column;
            height: 100%;
        }

        .week-header {
            display: grid;
            grid-template-columns: 80px repeat(7, 1fr);
            gap: 1px;
            margin-bottom: 1rem;
            border-bottom: 1px solid rgba(255, 255, 255, 0.3);
            padding-bottom: 1rem;
        }

        .week-time-label {
            /* Empty space for time column */
        }

        .week-day-header {
            text-align: center;
            font-size: 0.9rem;
            font-weight: 600;
            color: #6b7c6d;
            padding: 0.5rem 0;
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }

        .week-day-header.today {
            color: #ff6b6b;
            font-weight: 700;
        }

        .week-content {
            flex: 1;
            display: grid;
            grid-template-columns: 80px repeat(7, 1fr);
            gap: 1px;
            overflow-y: auto;
        }

        .week-time-column {
            display: flex;
            flex-direction: column;
        }

        .week-time-slot {
            height: 60px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.2);
            font-size: 0.8rem;
            color: #6b7c6d;
            padding-top: 0.5rem;
            text-align: right;
            padding-right: 0.5rem;
        }

        .week-day-column {
            border-right: 1px solid rgba(255, 255, 255, 0.2);
            position: relative;
        }

        .week-day-column:last-child {
            border-right: none;
        }

        .week-time-grid {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
        }

        .week-hour-line {
            height: 60px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            position: relative;
        }

        .week-event {
            position: absolute;
            left: 2px;
            right: 2px;
            background: linear-gradient(135deg, #6b7c6d 0%, #4a5a4c 100%);
            color: white;
            border-radius: 4px;
            padding: 0.25rem 0.5rem;
            font-size: 0.75rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.2s ease;
            z-index: 10;
        }

        .week-event:hover {
            transform: scale(1.02);
            opacity: 0.9;
        }

        .week-event.interview {
            background: linear-gradient(135deg, #6b7c6d 0%, #4a5a4c 100%);
        }

        .week-event.deadline {
            background: linear-gradient(135deg, #d2691e 0%, #a0522d 100%);
        }

        .week-event.application {
            background: linear-gradient(135deg, #ff6b6b 0%, #ff5252 100%);
        }

        /* Day View */
        .day-view {
            display: flex;
            flex-direction: column;
            height: 100%;
        }

        .day-header {
            text-align: center;
            margin-bottom: 2rem;
            padding-bottom: 1rem;
            border-bottom: 1px solid rgba(255, 255, 255, 0.3);
        }

        .day-date {
            font-size: 2rem;
            font-weight: 700;
            color: #2d3e2e;
            margin-bottom: 0.5rem;
        }

        .day-name {
            font-size: 1.1rem;
            color: #6b7c6d;
            font-weight: 600;
        }

        .day-content {
            flex: 1;
            display: grid;
            grid-template-columns: 80px 1fr;
            gap: 1rem;
            overflow-y: auto;
        }

        .day-time-column {
            display: flex;
            flex-direction: column;
        }

        .day-time-slot {
            height: 80px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.2);
            font-size: 0.9rem;
            color: #6b7c6d;
            padding-top: 0.5rem;
            text-align: right;
            padding-right: 1rem;
            font-weight: 500;
        }

        .day-events-column {
            position: relative;
            border-left: 1px solid rgba(255, 255, 255, 0.3);
            padding-left: 1rem;
        }

        .day-hour-line {
            height: 80px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            position: relative;
        }

        .day-event {
            position: absolute;
            left: 1rem;
            right: 1rem;
            background: rgba(255, 255, 255, 0.6);
            border-radius: 12px;
            padding: 1rem;
            margin-bottom: 0.5rem;
            border-left: 4px solid #ff6b6b;
            cursor: pointer;
            transition: all 0.3s cubic-bezier(0.23, 1, 0.32, 1);
            box-shadow: 0 2px 8px rgba(45, 62, 46, 0.1);
        }

        .day-event:hover {
            background: rgba(255, 255, 255, 0.8);
            transform: translateY(-2px);
            box-shadow: 0 8px 24px rgba(45, 62, 46, 0.1);
        }

        .day-event.interview {
            border-left-color: #6b7c6d;
        }

        .day-event.deadline {
            border-left-color: #d2691e;
        }

        .day-event.application {
            border-left-color: #ff6b6b;
        }

        .day-event-time {
            font-size: 0.8rem;
            color: #6b7c6d;
            font-weight: 600;
            margin-bottom: 0.25rem;
        }

        .day-event-title {
            font-size: 1rem;
            font-weight: 700;
            color: #2d3e2e;
            margin-bottom: 0.25rem;
        }

        .day-event-company {
            font-size: 0.85rem;
            color: #6b7c6d;
            font-weight: 500;
        }

        .day-all-day-events {
            background: rgba(255, 255, 255, 0.3);
            border-radius: 12px;
            padding: 1rem;
            margin-bottom: 1rem;
        }

        .day-all-day-title {
            font-size: 0.9rem;
            font-weight: 600;
            color: #6b7c6d;
            margin-bottom: 0.5rem;
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }

        .day-all-day-event {
            background: rgba(255, 107, 107, 0.1);
            border-radius: 8px;
            padding: 0.5rem 0.75rem;
            margin-bottom: 0.5rem;
            border-left: 3px solid #ff6b6b;
        }

        .day-all-day-event:last-child {
            margin-bottom: 0;
        }

        .day-all-day-event-title {
            font-size: 0.85rem;
            font-weight: 600;
            color: #2d3e2e;
            margin-bottom: 0.25rem;
        }

        .day-all-day-event-company {
            font-size: 0.75rem;
            color: #6b7c6d;
            font-weight: 500;
        }

        .calendar-day {
            background: rgba(255, 255, 255, 0.3);
            border-radius: 12px;
            padding: 1rem;
            cursor: pointer;
            transition: all 0.3s cubic-bezier(0.23, 1, 0.32, 1);
            position: relative;
            display: flex;
            flex-direction: column;
            min-height: 100px;
        }

        .calendar-day:hover {
            background: rgba(255, 255, 255, 0.5);
            transform: translateY(-2px);
            box-shadow: 0 8px 24px rgba(45, 62, 46, 0.1);
        }

        .calendar-day.other-month {
            opacity: 0.3;
            pointer-events: none;
        }

        .calendar-day.today {
            background: rgba(255, 107, 107, 0.1);
            border: 2px solid rgba(255, 107, 107, 0.3);
        }

        .calendar-day.selected {
            background: rgba(255, 107, 107, 0.15);
            border: 2px solid #ff6b6b;
            box-shadow: 
                0 0 0 4px rgba(255, 107, 107, 0.1),
                0 12px 32px rgba(255, 107, 107, 0.2);
            animation: selectedGlow 2s ease-in-out infinite alternate;
        }

        @keyframes selectedGlow {
            from {
                box-shadow: 
                    0 0 0 4px rgba(255, 107, 107, 0.1),
                    0 12px 32px rgba(255, 107, 107, 0.2);
            }
            to {
                box-shadow: 
                    0 0 0 6px rgba(255, 107, 107, 0.15),
                    0 16px 40px rgba(255, 107, 107, 0.3);
            }
        }

        .day-number {
            font-size: 1.1rem;
            font-weight: 600;
            color: #2d3e2e;
            margin-bottom: 0.5rem;
        }

        .day-events {
            flex: 1;
            display: flex;
            flex-direction: column;
            gap: 0.25rem;
        }

        .event-pill {
            padding: 0.25rem 0.75rem;
            border-radius: 20px;
            font-size: 0.7rem;
            font-weight: 600;
            color: white;
            text-overflow: ellipsis;
            overflow: hidden;
            white-space: nowrap;
            transition: all 0.2s ease;
            cursor: pointer;
        }

        .event-pill:hover {
            transform: scale(1.05);
            opacity: 0.9;
        }

        .event-pill.interview {
            background: linear-gradient(135deg, #6b7c6d 0%, #4a5a4c 100%);
            box-shadow: 0 2px 8px rgba(107, 124, 109, 0.3);
        }

        .event-pill.deadline {
            background: linear-gradient(135deg, #d2691e 0%, #a0522d 100%);
            box-shadow: 0 2px 8px rgba(210, 105, 30, 0.3);
        }

        .event-pill.application {
            background: linear-gradient(135deg, #ff6b6b 0%, #ff5252 100%);
            box-shadow: 0 2px 8px rgba(255, 107, 107, 0.3);
        }

        .more-events {
            font-size: 0.7rem;
            color: #6b7c6d;
            font-weight: 600;
            text-align: center;
            margin-top: 0.25rem;
            cursor: pointer;
        }

        .more-events:hover {
            color: #ff6b6b;
        }

        /* Side Panel */
        .side-panel {
            width: 380px;
            background: rgba(255, 255, 255, 0.5);
            backdrop-filter: blur(40px);
            border: 1px solid rgba(255, 255, 255, 0.4);
            border-radius: 24px;
            padding: 2rem;
            display: flex;
            flex-direction: column;
            position: relative;
            overflow: hidden;
        }

        .side-panel::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(135deg, 
                rgba(255, 255, 255, 0.1) 0%, 
                rgba(255, 107, 107, 0.02) 50%, 
                rgba(255, 255, 255, 0.05) 100%);
            border-radius: 24px;
            pointer-events: none;
        }

        .panel-content {
            position: relative;
            z-index: 2;
            height: 100%;
        }

        .panel-header {
            margin-bottom: 2rem;
        }

        .selected-date {
            font-size: 2rem;
            font-weight: 800;
            color: #2d3e2e;
            margin-bottom: 0.5rem;
            letter-spacing: -0.02em;
        }

        .selected-day-name {
            font-size: 1rem;
            color: #6b7c6d;
            font-weight: 600;
        }

        .events-section {
            flex: 1;
            overflow-y: auto;
        }

        .section-title {
            font-size: 1.2rem;
            font-weight: 700;
            color: #2d3e2e;
            margin-bottom: 1rem;
            letter-spacing: -0.01em;
        }

        .event-item {
            background: rgba(255, 255, 255, 0.6);
            border-radius: 16px;
            padding: 1.5rem;
            margin-bottom: 1rem;
            transition: all 0.3s cubic-bezier(0.23, 1, 0.32, 1);
            cursor: pointer;
            border: 1px solid rgba(255, 255, 255, 0.3);
        }

        .event-item:hover {
            background: rgba(255, 255, 255, 0.8);
            transform: translateY(-2px);
            box-shadow: 0 8px 24px rgba(45, 62, 46, 0.1);
        }

        .event-header {
            display: flex;
            align-items: center;
            gap: 1rem;
            margin-bottom: 0.75rem;
        }

        .event-type-badge {
            padding: 0.4rem 1rem;
            border-radius: 20px;
            font-size: 0.75rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }

        .event-type-badge.interview {
            background: rgba(107, 124, 109, 0.15);
            color: #4a5a4c;
        }

        .event-type-badge.deadline {
            background: rgba(210, 105, 30, 0.15);
            color: #a0522d;
        }

        .event-type-badge.application {
            background: rgba(255, 107, 107, 0.15);
            color: #ff4444;
        }

        .event-time {
            font-size: 0.85rem;
            color: #6b7c6d;
            font-weight: 600;
            margin-left: auto;
        }

        .event-title {
            font-size: 1.1rem;
            font-weight: 700;
            color: #2d3e2e;
            margin-bottom: 0.25rem;
        }

        .event-company {
            font-size: 0.9rem;
            color: #6b7c6d;
            font-weight: 500;
        }

        .no-events {
            text-align: center;
            color: #6b7c6d;
            font-style: italic;
            padding: 3rem 1rem;
        }

        .add-event-btn {
            background: linear-gradient(135deg, #ff6b6b 0%, #ff5252 100%);
            color: white;
            border: none;
            padding: 1rem 2rem;
            border-radius: 50px;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s cubic-bezier(0.23, 1, 0.32, 1);
            margin-top: 1rem;
            font-family: 'Inter', sans-serif;
            letter-spacing: -0.01em;
            box-shadow: 0 8px 24px rgba(255, 107, 107, 0.3);
        }

        .add-event-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 12px 32px rgba(255, 107, 107, 0.4);
            background: linear-gradient(135deg, #ff5252 0%, #ff4444 100%);
        }

        /* Responsive Design */
        @media (max-width: 1400px) {
            .container {
                padding: 1.5rem;
                gap: 1.5rem;
            }
            
            .side-panel {
                width: 320px;
            }
            
            .page-title {
                font-size: 2.5rem;
            }
        }

        @media (max-width: 1200px) {
            .container {
                flex-direction: column;
                height: auto;
                min-height: calc(100vh - 120px);
                padding: 1rem;
                gap: 1rem;
            }
            
            .side-panel {
                width: 100%;
                order: -1;
                max-height: 300px;
                overflow-y: auto;
            }
            
            .calendar-grid {
                min-height: 500px;
            }
            
            .calendar-header {
                margin-bottom: 1.5rem;
            }
        }

        @media (max-width: 968px) {
            .navbar {
                padding: 1rem;
                margin: 0;
                border-radius: 0;
            }
            
            .nav-links {
                gap: 1rem;
            }
            
            .nav-link {
                font-size: 0.85rem;
                padding: 0.4rem 0.8rem;
            }
        }

        @media (max-width: 768px) {
            .container {
                padding: 0.8rem;
                gap: 0.8rem;
            }
            
            .navbar {
                padding: 0.8rem 1rem;
            }
            
            .brand {
                font-size: 1.6rem;
            }
            
            .nav-links {
                display: none;
            }
            
            .page-title {
                font-size: 2rem;
            }
            
            .page-subtitle {
                font-size: 1rem;
            }
            
            .calendar-header {
                flex-direction: column;
                gap: 1rem;
                align-items: stretch;
                margin-bottom: 1rem;
            }
            
            .calendar-controls {
                justify-content: space-between;
                flex-wrap: wrap;
                gap: 0.5rem;
            }
            
            .month-nav {
                padding: 0.5rem 1rem;
            }
            
            .current-month {
                font-size: 1rem;
                min-width: 120px;
            }
            
            .view-toggle {
                order: 2;
                width: 100%;
                margin-top: 0.5rem;
            }
            
            .toggle-btn {
                flex: 1;
                padding: 0.6rem 1rem;
                font-size: 0.8rem;
            }
            
            .calendar-grid {
                padding: 1rem;
                min-height: 400px;
            }
            
            /* Month View Mobile */
            .calendar-day {
                padding: 0.4rem;
                min-height: 70px;
            }
            
            .day-number {
                font-size: 0.9rem;
                margin-bottom: 0.3rem;
            }
            
            .event-pill {
                font-size: 0.55rem;
                padding: 0.15rem 0.4rem;
                margin-bottom: 0.1rem;
            }
            
            /* Week View Mobile */
            .week-content {
                grid-template-columns: 60px repeat(7, 1fr);
            }
            
            .week-time-slot {
                height: 40px;
                font-size: 0.7rem;
                padding-right: 0.25rem;
            }
            
            .week-hour-line {
                height: 40px;
            }
            
            .week-event {
                font-size: 0.6rem;
                padding: 0.2rem 0.3rem;
                min-height: 30px;
            }
            
            .week-day-header {
                font-size: 0.75rem;
                padding: 0.25rem 0;
            }
            
            /* Day View Mobile */
            .day-content {
                grid-template-columns: 60px 1fr;
            }
            
            .day-time-slot {
                height: 60px;
                font-size: 0.75rem;
                padding-right: 0.5rem;
            }
            
            .day-hour-line {
                height: 60px;
            }
            
            .day-event {
                padding: 0.75rem;
                margin-bottom: 0.25rem;
            }
            
            .day-event-title {
                font-size: 0.9rem;
            }
            
            .day-event-company {
                font-size: 0.75rem;
            }
            
            .day-date {
                font-size: 1.5rem;
            }
            
            .day-name {
                font-size: 1rem;
            }
            
            /* Side Panel Mobile */
            .side-panel {
                padding: 1rem;
                max-height: 250px;
            }
            
            .selected-date {
                font-size: 1.5rem;
            }
            
            .event-item {
                padding: 1rem;
            }
            
            .event-title {
                font-size: 1rem;
            }
            
            .event-company {
                font-size: 0.8rem;
            }
        }

        @media (max-width: 480px) {
            .container {
                padding: 0.5rem;
            }
            
            .navbar {
                padding: 0.6rem 0.8rem;
            }
            
            .brand {
                font-size: 1.4rem;
            }
            
            .user-name {
                display: none;
            }
            
            .logout-btn {
                padding: 0.5rem 1rem;
                font-size: 0.8rem;
            }
            
            .page-title {
                font-size: 1.6rem;
            }
            
            .page-subtitle {
                font-size: 0.9rem;
            }
            
            .calendar-header {
                text-align: center;
            }
            
            .month-nav {
                padding: 0.4rem 0.8rem;
            }
            
            .current-month {
                font-size: 0.8rem;
                min-width: 80px;
            }
            
            .nav-button {
                width: 32px;
                height: 32px;
                font-size: 1rem;
            }
            
            .calendar-grid {
                padding: 0.5rem;
            }
            
            /* Month View Extra Small */
            .calendar-days {
                grid-template-rows: repeat(6, 60px);
                gap: 2px;
            }
            
            .calendar-day {
                min-height: 55px;
                padding: 0.2rem;
                border-radius: 8px;
            }
            
            .day-number {
                font-size: 0.8rem;
                margin-bottom: 0.2rem;
            }
            
            .event-pill {
                display: none;
            }
            
            .calendar-day.has-events::after {
                content: '';
                position: absolute;
                bottom: 3px;
                right: 3px;
                width: 5px;
                height: 5px;
                background: #ff6b6b;
                border-radius: 50%;
                box-shadow: 0 0 4px rgba(255, 107, 107, 0.5);
            }
            
            /* Week View Extra Small */
            .week-content {
                grid-template-columns: 40px repeat(7, 1fr);
            }
            
            .week-time-slot {
                height: 30px;
                font-size: 0.6rem;
                padding-right: 0.2rem;
            }
            
            .week-hour-line {
                height: 30px;
            }
            
            .week-event {
                font-size: 0.5rem;
                padding: 0.1rem 0.2rem;
                min-height: 20px;
            }
            
            .week-day-header {
                font-size: 0.65rem;
                padding: 0.2rem 0;
            }
            
            /* Day View Extra Small */
            .day-content {
                grid-template-columns: 40px 1fr;
            }
            
            .day-time-slot {
                height: 40px;
                font-size: 0.65rem;
                padding-right: 0.25rem;
            }
            
            .day-hour-line {
                height: 40px;
            }
            
            .day-event {
                padding: 0.5rem;
                margin-bottom: 0.2rem;
                min-height: 30px;
            }
            
            .day-event-title {
                font-size: 0.8rem;
            }
            
            .day-event-company {
                font-size: 0.7rem;
            }
            
            .day-event-time {
                font-size: 0.65rem;
            }
            
            .day-date {
                font-size: 1.2rem;
            }
            
            .day-name {
                font-size: 0.9rem;
            }
            
            .day-all-day-events {
                padding: 0.5rem;
                margin-bottom: 0.5rem;
            }
            
            .day-all-day-event {
                padding: 0.4rem 0.5rem;
            }
            
            /* Side Panel Extra Small */
            .side-panel {
                padding: 0.8rem;
                max-height: 200px;
            }
            
            .selected-date {
                font-size: 1.3rem;
            }
            
            .selected-day-name {
                font-size: 0.9rem;
            }
            
            .section-title {
                font-size: 1rem;
            }
            
            .event-item {
                padding: 0.8rem;
                margin-bottom: 0.5rem;
            }
            
            .event-title {
                font-size: 0.9rem;
            }
            
            .event-company {
                font-size: 0.75rem;
            }
            
            .event-time {
                font-size: 0.75rem;
            }
            
            .add-event-btn {
                padding: 0.8rem 1.5rem;
                font-size: 0.9rem;
            }
        }

        /* Scroll styling */
        .events-section::-webkit-scrollbar {
            width: 4px;
        }

        .events-section::-webkit-scrollbar-track {
            background: rgba(255, 255, 255, 0.1);
        }

        .events-section::-webkit-scrollbar-thumb {
            background: rgba(255, 107, 107, 0.3);
            border-radius: 2px;
        }

        /* Accessibility */
        @media (prefers-reduced-motion: reduce) {
            .calendar-day,
            .event-pill,
            .event-item,
            .add-event-btn {
                transition: none;
            }
            
            .calendar-day.selected {
                animation: none;
            }
            
            .calendar-day:hover,
            .event-item:hover {
                transform: none;
            }
        }
        </style>
    </x-slot>

    <div class="container">
        <!-- Calendar Section -->
        <div class="calendar-section">
            <!-- Header -->
            <div class="calendar-header">
                <div class="header-left">
                    <h1 class="page-title">Calendar</h1>
                    <p class="page-subtitle">Track your interviews and application deadlines</p>
                </div>
                
                <div class="calendar-controls">
                    <div class="month-nav">
                        <button class="nav-button" onclick="previousPeriod()">‹</button>
                        <span class="current-month" id="currentMonth">{{ date('F Y') }}</span>
                        <button class="nav-button" onclick="nextPeriod()">›</button>
                    </div>
                    
                    <div class="view-toggle">
                        <button class="toggle-btn active" title="Month View (Ctrl+M)">Month</button>
                        <button class="toggle-btn" title="Week View (Ctrl+W)">Week</button>
                        <button class="toggle-btn" title="Day View (Ctrl+D)">Day</button>
                    </div>
                </div>
            </div>

            <!-- Calendar Grid -->
            <div class="calendar-grid">
                <!-- Month View -->
                <div class="calendar-view active" id="monthView">
                    <div class="calendar-days-header">
                        <div class="day-header">Sun</div>
                        <div class="day-header">Mon</div>
                        <div class="day-header">Tue</div>
                        <div class="day-header">Wed</div>
                        <div class="day-header">Thu</div>
                        <div class="day-header">Fri</div>
                        <div class="day-header">Sat</div>
                    </div>
                    
                    <div class="calendar-days" id="calendarDays">
                        <!-- Calendar days will be generated by JavaScript -->
                    </div>
                </div>

                <!-- Week View -->
                <div class="calendar-view" id="weekView">
                    <div class="week-view">
                        <div class="week-header" id="weekHeader">
                            <!-- Week header will be generated by JavaScript -->
                        </div>
                        <div class="week-content" id="weekContent">
                            <!-- Week content will be generated by JavaScript -->
                        </div>
                    </div>
                </div>

                <!-- Day View -->
                <div class="calendar-view" id="dayView">
                    <div class="day-view">
                        <div class="day-header" id="dayHeader">
                            <!-- Day header will be generated by JavaScript -->
                        </div>
                        <div class="day-all-day-events" id="dayAllDayEvents" style="display: none;">
                            <div class="day-all-day-title">All Day</div>
                            <div id="allDayEventsList">
                                <!-- All day events will be generated by JavaScript -->
                            </div>
                        </div>
                        <div class="day-content" id="dayContent">
                            <!-- Day content will be generated by JavaScript -->
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Side Panel -->
        <div class="side-panel">
            <div class="panel-content">
                <div class="panel-header">
                    <div class="selected-date" id="selectedDate">{{ date('M j') }}</div>
                    <div class="selected-day-name" id="selectedDayName">{{ date('l') }}</div>
                </div>
                
                <div class="events-section">
                    <h3 class="section-title">Today's Events</h3>
                    
                    <div id="eventsList">
                        @if($todaysEvents->count() > 0)
                            @foreach($todaysEvents as $event)
                                <div class="event-item">
                                    <div class="event-header">
                                        <div class="event-type-badge {{ $event->type }}">{{ ucfirst($event->type) }}</div>
                                        <div class="event-time">{{ $event->time }}</div>
                                    </div>
                                    <div class="event-title">{{ $event->title }}</div>
                                    <div class="event-company">{{ $event->company }} - {{ $event->position }}</div>
                                </div>
                            @endforeach
                        @else
                            <div class="no-events">No events scheduled for today</div>
                        @endif
                    </div>
                </div>
                
                <button class="add-event-btn" onclick="addEvent()">
                    + Add Event
                </button>
                
                <div style="margin-top: 1rem; text-align: center;">
                    <a href="{{ route('dashboard') }}" style="color: #6b7c6d; text-decoration: none; font-size: 0.9rem; font-weight: 500;">
                        ← Back to Dashboard
                    </a>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Calendar data - this would be populated from your database
        const currentDate = new Date();
        let selectedDate = new Date();
        let currentMonth = new Date();
        let currentView = 'month'; // 'month', 'week', 'day'

        // Sample events data - replace with data from your Laravel backend
        const events = @json($events ?? []);

        function generateCalendar() {
            const calendarDays = document.getElementById('calendarDays');
            calendarDays.innerHTML = '';

            const year = currentMonth.getFullYear();
            const month = currentMonth.getMonth();
            
            // Get first day of month and number of days
            const firstDay = new Date(year, month, 1);
            const lastDay = new Date(year, month + 1, 0);
            const daysInMonth = lastDay.getDate();
            const startingDayOfWeek = firstDay.getDay();

            // Add previous month's trailing days
            const prevMonth = new Date(year, month - 1, 0);
            for (let i = startingDayOfWeek - 1; i >= 0; i--) {
                const day = prevMonth.getDate() - i;
                const dayElement = createDayElement(day, true);
                calendarDays.appendChild(dayElement);
            }

            // Add current month's days
            for (let day = 1; day <= daysInMonth; day++) {
                const dayElement = createDayElement(day, false);
                calendarDays.appendChild(dayElement);
            }

            // Add next month's leading days to fill the grid
            const remainingCells = 42 - (startingDayOfWeek + daysInMonth);
            for (let day = 1; day <= remainingCells; day++) {
                const dayElement = createDayElement(day, true);
                calendarDays.appendChild(dayElement);
            }

            // Update month display
            updateMonthDisplay();
        }

        function createDayElement(day, isOtherMonth) {
            const dayElement = document.createElement('div');
            dayElement.className = 'calendar-day';
            
            if (isOtherMonth) {
                dayElement.classList.add('other-month');
            }

            const year = currentMonth.getFullYear();
            const month = currentMonth.getMonth();
            const dayDate = new Date(year, month, day);
            
            // Check if it's today
            if (!isOtherMonth && isSameDay(dayDate, currentDate)) {
                dayElement.classList.add('today');
            }
            
            // Check if it's selected
            if (!isOtherMonth && isSameDay(dayDate, selectedDate)) {
                dayElement.classList.add('selected');
            }

            dayElement.innerHTML = `
                <div class="day-number">${day}</div>
                <div class="day-events" id="events-${year}-${month + 1}-${day}"></div>
            `;

            // Add events for this day
            if (!isOtherMonth) {
                const dateKey = `${year}-${String(month + 1).padStart(2, '0')}-${String(day).padStart(2, '0')}`;
                const dayEvents = events[dateKey] || [];
                
                if (dayEvents.length > 0) {
                    dayElement.classList.add('has-events');
                    const eventsContainer = dayElement.querySelector('.day-events');
                    
                    // Show up to 3 events, then "X more"
                    const visibleEvents = dayEvents.slice(0, 3);
                    visibleEvents.forEach(event => {
                        const eventPill = document.createElement('div');
                        eventPill.className = `event-pill ${event.type}`;
                        eventPill.textContent = event.title;
                        eventPill.title = `${event.time} - ${event.company}`;
                        eventsContainer.appendChild(eventPill);
                    });
                    
                    if (dayEvents.length > 3) {
                        const moreEvents = document.createElement('div');
                        moreEvents.className = 'more-events';
                        moreEvents.textContent = `+${dayEvents.length - 3} more`;
                        eventsContainer.appendChild(moreEvents);
                    }
                }
            }

            // Add click handler
            if (!isOtherMonth) {
                dayElement.addEventListener('click', () => selectDay(dayDate));
            }

            return dayElement;
        }

        function selectDay(date) {
            // Remove previous selection
            document.querySelectorAll('.calendar-day.selected').forEach(day => {
                day.classList.remove('selected');
            });
            
            // Add selection to clicked day
            event.currentTarget.classList.add('selected');
            
            selectedDate = new Date(date);
            updateSidePanel();
        }

        function updateSidePanel() {
            const selectedDateElement = document.getElementById('selectedDate');
            const selectedDayNameElement = document.getElementById('selectedDayName');
            const eventsListElement = document.getElementById('eventsList');

            // Format date
            const options = { month: 'short', day: 'numeric' };
            selectedDateElement.textContent = selectedDate.toLocaleDateString('en-US', options);
            
            const dayOptions = { weekday: 'long' };
            selectedDayNameElement.textContent = selectedDate.toLocaleDateString('en-US', dayOptions);

            // Get events for selected day
            const dateKey = `${selectedDate.getFullYear()}-${String(selectedDate.getMonth() + 1).padStart(2, '0')}-${String(selectedDate.getDate()).padStart(2, '0')}`;
            const dayEvents = events[dateKey] || [];

            // Update events list
            if (dayEvents.length === 0) {
                eventsListElement.innerHTML = '<div class="no-events">No events scheduled for this day</div>';
            } else {
                eventsListElement.innerHTML = dayEvents.map(event => `
                    <div class="event-item">
                        <div class="event-header">
                            <div class="event-type-badge ${event.type}">${event.type}</div>
                            <div class="event-time">${event.time}</div>
                        </div>
                        <div class="event-title">${event.title}</div>
                        <div class="event-company">${event.company}</div>
                    </div>
                `).join('');
            }
        }

        function updateMonthDisplay() {
            const currentMonthElement = document.getElementById('currentMonth');
            let displayText = '';
            
            switch (currentView) {
                case 'month':
                    const options = { month: 'long', year: 'numeric' };
                    displayText = currentMonth.toLocaleDateString('en-US', options);
                    break;
                case 'week':
                    const startOfWeek = new Date(selectedDate);
                    startOfWeek.setDate(selectedDate.getDate() - selectedDate.getDay());
                    const endOfWeek = new Date(startOfWeek);
                    endOfWeek.setDate(startOfWeek.getDate() + 6);
                    
                    if (startOfWeek.getMonth() === endOfWeek.getMonth()) {
                        displayText = `${startOfWeek.toLocaleDateString('en-US', { month: 'long' })} ${startOfWeek.getDate()} - ${endOfWeek.getDate()}, ${startOfWeek.getFullYear()}`;
                    } else {
                        displayText = `${startOfWeek.toLocaleDateString('en-US', { month: 'short', day: 'numeric' })} - ${endOfWeek.toLocaleDateString('en-US', { month: 'short', day: 'numeric' })}, ${endOfWeek.getFullYear()}`;
                    }
                    break;
                case 'day':
                    displayText = selectedDate.toLocaleDateString('en-US', { weekday: 'long', month: 'long', day: 'numeric', year: 'numeric' });
                    break;
            }
            
            currentMonthElement.textContent = displayText;
        }

        function previousPeriod() {
            switch (currentView) {
                case 'month':
                    currentMonth.setMonth(currentMonth.getMonth() - 1);
                    break;
                case 'week':
                    selectedDate.setDate(selectedDate.getDate() - 7);
                    currentMonth = new Date(selectedDate.getFullYear(), selectedDate.getMonth(), 1);
                    break;
                case 'day':
                    selectedDate.setDate(selectedDate.getDate() - 1);
                    currentMonth = new Date(selectedDate.getFullYear(), selectedDate.getMonth(), 1);
                    break;
            }
            switchView(currentView);
            updateMonthDisplay();
        }

        function nextPeriod() {
            switch (currentView) {
                case 'month':
                    currentMonth.setMonth(currentMonth.getMonth() + 1);
                    break;
                case 'week':
                    selectedDate.setDate(selectedDate.getDate() + 7);
                    currentMonth = new Date(selectedDate.getFullYear(), selectedDate.getMonth(), 1);
                    break;
                case 'day':
                    selectedDate.setDate(selectedDate.getDate() + 1);
                    currentMonth = new Date(selectedDate.getFullYear(), selectedDate.getMonth(), 1);
                    break;
            }
            switchView(currentView);
            updateMonthDisplay();
        }
        
        // Keep old functions for backward compatibility
        function previousMonth() {
            previousPeriod();
        }
        
        function nextMonth() {
            nextPeriod();
        }

        function isSameDay(date1, date2) {
            return date1.getDate() === date2.getDate() &&
                   date1.getMonth() === date2.getMonth() &&
                   date1.getFullYear() === date2.getFullYear();
        }

        function addEvent() {
            console.log('Adding new event for', selectedDate.toDateString());
            // This would integrate with your existing application modal
            // For now, redirect to applications page with a suggestion to add events via the application form
            if (confirm('To add calendar events, create a new job application with interview dates and deadlines. Would you like to go to the applications page?')) {
                window.location.href = '{{ route('applications.index') }}';
            }
        }

        // View switching functions
        function switchView(viewType) {
            currentView = viewType;
            
            // Update toggle buttons
            document.querySelectorAll('.toggle-btn').forEach(btn => {
                btn.classList.remove('active');
                if (btn.textContent.toLowerCase() === viewType) {
                    btn.classList.add('active');
                }
            });
            
            // Hide all views
            document.querySelectorAll('.calendar-view').forEach(view => {
                view.classList.remove('active');
            });
            
            // Show selected view
            const viewElement = document.getElementById(viewType + 'View');
            if (viewElement) {
                viewElement.classList.add('active');
            }
            
            // Generate content for the selected view
            switch (viewType) {
                case 'month':
                    generateCalendar();
                    break;
                case 'week':
                    generateWeekView();
                    break;
                case 'day':
                    generateDayView();
                    break;
            }
            
            updateSidePanel();
        }
        
        function generateWeekView() {
            const weekHeader = document.getElementById('weekHeader');
            const weekContent = document.getElementById('weekContent');
            
            // Clear existing content
            weekHeader.innerHTML = '';
            weekContent.innerHTML = '';
            
            // Get start of week (Sunday)
            const startOfWeek = new Date(selectedDate);
            startOfWeek.setDate(selectedDate.getDate() - selectedDate.getDay());
            
            // Create header
            const timeLabel = document.createElement('div');
            timeLabel.className = 'week-time-label';
            weekHeader.appendChild(timeLabel);
            
            const weekDays = [];
            for (let i = 0; i < 7; i++) {
                const day = new Date(startOfWeek);
                day.setDate(startOfWeek.getDate() + i);
                weekDays.push(day);
                
                const dayHeader = document.createElement('div');
                dayHeader.className = 'week-day-header';
                if (isSameDay(day, currentDate)) {
                    dayHeader.classList.add('today');
                }
                dayHeader.innerHTML = `
                    <div>${day.toLocaleDateString('en-US', { weekday: 'short' })}</div>
                    <div style="font-size: 1.2rem; margin-top: 0.25rem;">${day.getDate()}</div>
                `;
                weekHeader.appendChild(dayHeader);
            }
            
            // Create time column
            const timeColumn = document.createElement('div');
            timeColumn.className = 'week-time-column';
            
            for (let hour = 0; hour < 24; hour++) {
                const timeSlot = document.createElement('div');
                timeSlot.className = 'week-time-slot';
                const displayHour = hour === 0 ? 12 : hour > 12 ? hour - 12 : hour;
                const ampm = hour < 12 ? 'AM' : 'PM';
                timeSlot.textContent = `${displayHour}:00 ${ampm}`;
                timeColumn.appendChild(timeSlot);
            }
            weekContent.appendChild(timeColumn);
            
            // Create day columns
            weekDays.forEach((day, dayIndex) => {
                const dayColumn = document.createElement('div');
                dayColumn.className = 'week-day-column';
                
                const timeGrid = document.createElement('div');
                timeGrid.className = 'week-time-grid';
                
                // Create hour lines
                for (let hour = 0; hour < 24; hour++) {
                    const hourLine = document.createElement('div');
                    hourLine.className = 'week-hour-line';
                    timeGrid.appendChild(hourLine);
                }
                
                // Add events for this day
                const dateKey = day.toISOString().split('T')[0];
                const dayEvents = events[dateKey] || [];
                
                dayEvents.forEach(event => {
                    if (event.time && event.time !== 'All Day') {
                        const eventElement = document.createElement('div');
                        eventElement.className = `week-event ${event.type}`;
                        eventElement.innerHTML = `
                            <div style="font-weight: 700; margin-bottom: 0.25rem;">${event.time}</div>
                            <div style="font-size: 0.7rem;">${event.title}</div>
                        `;
                        
                        // Position event based on time
                        const time = parseTime(event.time);
                        if (time !== null) {
                            const topPosition = (time.hours * 60 + time.minutes) * (60 / 60); // 60px per hour
                            eventElement.style.top = topPosition + 'px';
                            eventElement.style.height = '50px'; // Default event height
                        }
                        
                        timeGrid.appendChild(eventElement);
                    }
                });
                
                dayColumn.appendChild(timeGrid);
                weekContent.appendChild(dayColumn);
            });
        }
        
        function generateDayView() {
            const dayHeader = document.getElementById('dayHeader');
            const dayContent = document.getElementById('dayContent');
            const dayAllDayEvents = document.getElementById('dayAllDayEvents');
            const allDayEventsList = document.getElementById('allDayEventsList');
            
            // Clear existing content
            dayHeader.innerHTML = '';
            dayContent.innerHTML = '';
            allDayEventsList.innerHTML = '';
            
            // Set header
            dayHeader.innerHTML = `
                <div class="day-date">${selectedDate.getDate()}</div>
                <div class="day-name">${selectedDate.toLocaleDateString('en-US', { weekday: 'long', month: 'long', year: 'numeric' })}</div>
            `;
            
            // Get events for selected day
            const dateKey = selectedDate.toISOString().split('T')[0];
            const dayEvents = events[dateKey] || [];
            
            // Separate all-day and timed events
            const allDayEvents = dayEvents.filter(event => event.time === 'All Day');
            const timedEvents = dayEvents.filter(event => event.time !== 'All Day');
            
            // Show all-day events if any
            if (allDayEvents.length > 0) {
                dayAllDayEvents.style.display = 'block';
                allDayEvents.forEach(event => {
                    const eventElement = document.createElement('div');
                    eventElement.className = `day-all-day-event ${event.type}`;
                    eventElement.innerHTML = `
                        <div class="day-all-day-event-title">${event.title}</div>
                        <div class="day-all-day-event-company">${event.company}</div>
                    `;
                    allDayEventsList.appendChild(eventElement);
                });
            } else {
                dayAllDayEvents.style.display = 'none';
            }
            
            // Create time column
            const timeColumn = document.createElement('div');
            timeColumn.className = 'day-time-column';
            
            for (let hour = 0; hour < 24; hour++) {
                const timeSlot = document.createElement('div');
                timeSlot.className = 'day-time-slot';
                const displayHour = hour === 0 ? 12 : hour > 12 ? hour - 12 : hour;
                const ampm = hour < 12 ? 'AM' : 'PM';
                timeSlot.textContent = `${displayHour}:00 ${ampm}`;
                timeColumn.appendChild(timeSlot);
            }
            dayContent.appendChild(timeColumn);
            
            // Create events column
            const eventsColumn = document.createElement('div');
            eventsColumn.className = 'day-events-column';
            
            // Create hour lines
            for (let hour = 0; hour < 24; hour++) {
                const hourLine = document.createElement('div');
                hourLine.className = 'day-hour-line';
                eventsColumn.appendChild(hourLine);
            }
            
            // Add timed events
            timedEvents.forEach(event => {
                const eventElement = document.createElement('div');
                eventElement.className = `day-event ${event.type}`;
                eventElement.innerHTML = `
                    <div class="day-event-time">${event.time}</div>
                    <div class="day-event-title">${event.title}</div>
                    <div class="day-event-company">${event.company}</div>
                `;
                
                // Position event based on time
                const time = parseTime(event.time);
                if (time !== null) {
                    const topPosition = (time.hours * 80) + (time.minutes * 80 / 60); // 80px per hour
                    eventElement.style.top = topPosition + 'px';
                    eventElement.style.minHeight = '60px';
                }
                
                eventsColumn.appendChild(eventElement);
            });
            
            dayContent.appendChild(eventsColumn);
        }
        
        function parseTime(timeString) {
            if (!timeString || timeString === 'All Day') return null;
            
            const timeRegex = /(\d{1,2}):(\d{2})\s*(AM|PM)/i;
            const match = timeString.match(timeRegex);
            
            if (match) {
                let hours = parseInt(match[1]);
                const minutes = parseInt(match[2]);
                const ampm = match[3].toUpperCase();
                
                if (ampm === 'PM' && hours !== 12) hours += 12;
                if (ampm === 'AM' && hours === 12) hours = 0;
                
                return { hours, minutes };
            }
            
            return null;
        }
        
        // View toggle functionality
        document.querySelectorAll('.toggle-btn').forEach(btn => {
            btn.addEventListener('click', function() {
                const viewType = this.textContent.toLowerCase();
                switchView(viewType);
            });
        });

        // Initialize calendar
        document.addEventListener('DOMContentLoaded', function() {
            switchView('month'); // Start with month view
            updateMonthDisplay();
            
            // Add entrance animations
            const calendarSection = document.querySelector('.calendar-section');
            const sidePanel = document.querySelector('.side-panel');
            
            calendarSection.style.opacity = '0';
            calendarSection.style.transform = 'translateY(20px)';
            sidePanel.style.opacity = '0';
            sidePanel.style.transform = 'translateX(20px)';
            
            setTimeout(() => {
                calendarSection.style.transition = 'all 0.6s cubic-bezier(0.23, 1, 0.32, 1)';
                calendarSection.style.opacity = '1';
                calendarSection.style.transform = 'translateY(0)';
            }, 100);
            
            setTimeout(() => {
                sidePanel.style.transition = 'all 0.6s cubic-bezier(0.23, 1, 0.32, 1)';
                sidePanel.style.opacity = '1';
                sidePanel.style.transform = 'translateX(0)';
            }, 300);
        });

        // Keyboard navigation
        document.addEventListener('keydown', function(e) {
            let newDate = new Date(selectedDate);
            let shouldUpdate = true;
            
            switch(e.key) {
                case 'ArrowLeft':
                    e.preventDefault();
                    if (currentView === 'month') {
                        newDate.setDate(newDate.getDate() - 1);
                    } else if (currentView === 'week') {
                        newDate.setDate(newDate.getDate() - 1);
                    } else if (currentView === 'day') {
                        newDate.setDate(newDate.getDate() - 1);
                    }
                    break;
                case 'ArrowRight':
                    e.preventDefault();
                    if (currentView === 'month') {
                        newDate.setDate(newDate.getDate() + 1);
                    } else if (currentView === 'week') {
                        newDate.setDate(newDate.getDate() + 1);
                    } else if (currentView === 'day') {
                        newDate.setDate(newDate.getDate() + 1);
                    }
                    break;
                case 'ArrowUp':
                    e.preventDefault();
                    if (currentView === 'month') {
                        newDate.setDate(newDate.getDate() - 7);
                    } else if (currentView === 'week') {
                        newDate.setDate(newDate.getDate() - 7);
                    } else if (currentView === 'day') {
                        newDate.setDate(newDate.getDate() - 1);
                    }
                    break;
                case 'ArrowDown':
                    e.preventDefault();
                    if (currentView === 'month') {
                        newDate.setDate(newDate.getDate() + 7);
                    } else if (currentView === 'week') {
                        newDate.setDate(newDate.getDate() + 7);
                    } else if (currentView === 'day') {
                        newDate.setDate(newDate.getDate() + 1);
                    }
                    break;
                case 'Home':
                    e.preventDefault();
                    newDate = new Date(); // Go to today
                    break;
                case '1':
                case 'm':
                case 'M':
                    if (e.ctrlKey || e.metaKey) {
                        e.preventDefault();
                        switchView('month');
                        shouldUpdate = false;
                    }
                    break;
                case '2':
                case 'w':
                case 'W':
                    if (e.ctrlKey || e.metaKey) {
                        e.preventDefault();
                        switchView('week');
                        shouldUpdate = false;
                    }
                    break;
                case '3':
                case 'd':
                case 'D':
                    if (e.ctrlKey || e.metaKey) {
                        e.preventDefault();
                        switchView('day');
                        shouldUpdate = false;
                    }
                    break;
                default:
                    shouldUpdate = false;
                    return;
            }
            
            if (shouldUpdate) {
                // Check if we need to change the current month reference
                if (newDate.getMonth() !== currentMonth.getMonth() || newDate.getFullYear() !== currentMonth.getFullYear()) {
                    currentMonth = new Date(newDate.getFullYear(), newDate.getMonth(), 1);
                }
                
                selectedDate = newDate;
                switchView(currentView);
                updateMonthDisplay();
            }
        });
    </script>

    <x-slot name="scripts">
        <script>
            // Calendar specific JavaScript
        </script>
    </x-slot>
</x-layout>